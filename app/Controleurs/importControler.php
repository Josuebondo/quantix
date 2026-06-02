<?php

namespace App\Controleurs;

use App\BaseControleur;
use Core\Requete;
use Core\Reponse;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Core\BaseBD;
use Core\Storage\StorageManager;

/**
 * importControler Contrôleur
 */
class importControler extends BaseControleur
{
    /**
     * Exemple d'action
     */
    public function index(Requete $requete, Reponse $response): string
    {
        return vue('import.index');
    }
    public function analyze(Requete $requete, Reponse $response): string
    {
        try {

            // ===============================
            // 1. Vérification fichier
            // ===============================
            $file = $requete->fichier('file');

            if (!$file || !isset($file['tmp_name'])) {
                return json_encode([
                    "status" => "error",
                    "message" => "Aucun fichier envoyé"
                ]);
            }

            $allowedExtensions = ['xlsx', 'xls', 'csv'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                return json_encode([
                    "status" => "error",
                    "message" => "Format non supporté"
                ]);
            }

            // ===============================
            // 2. Chargement fichier
            // ===============================
            $spreadsheet = IOFactory::load($file['tmp_name']);
            $sheet = $spreadsheet->getActiveSheet();

            // ===============================
            // 3. Lecture sécurisée (SANS FORMULES)
            // ===============================
            $rows = [];
            $errors = [];

            foreach ($sheet->getRowIterator() as $rowIndex => $row) {

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];

                foreach ($cellIterator as $colIndex => $cell) {

                    try {
                        $value = $cell->getCalculatedValue();
                    } catch (\Exception $e) {
                        $value = null;
                    }

                    // 🔥 SUPPRIMER les formules non calculables
                    if ($cell->isFormula()) {
                        try {
                            $value = $cell->getCalculatedValue();
                        } catch (\Exception $e) {
                            $value = null;
                        }
                    }

                    // 🔥 Nettoyage valeurs invalides
                    if (is_string($value)) {

                        // supprimer formules restantes
                        if (str_starts_with($value, '=')) {
                            $value = null;
                        }

                        // trim
                        $value = trim($value);

                        // vider string vide
                        if ($value === '') {
                            $value = null;
                        }
                    }

                    $rowData[] = $value;
                }

                // ignorer lignes totalement vides
                if (array_filter($rowData)) {
                    $rows[] = $rowData;
                }
            }

            if (count($rows) < 2) {
                return json_encode([
                    "status" => "error",
                    "message" => "Fichier vide ou invalide"
                ]);
            }

            // ===============================
            // 4. Colonnes
            // ===============================
            $columns = array_map(function ($col) {
                return strtolower(trim((string)$col));
            }, $rows[0]);

            // ===============================
            // 5. Preview (10 lignes)
            // ===============================
            $preview = array_slice($rows, 1, 10);

            // ===============================
            // 6. JSON temporaire
            // ===============================
            $tempData = [
                "columns" => $columns,
                "rows" => array_slice($rows, 1)
            ];

            $tempFileName = 'import_' . uniqid() . '.json';
            $tempPath = StorageManager::chemin('temp/' . $tempFileName);

            if (!is_dir(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0777, true);
            }

            file_put_contents($tempPath, json_encode($tempData));

            // ===============================
            // 7. Tables (dynamique possible)
            // ===============================
            $tables = [
                "mouvements" => ["produit_id", "type", "quantite", "date_mouvement"],
                "stock" => [
                    "article_id",
                    "entrepot_id",
                    "stock_initial",
                    "stock_entree",
                    "stock_sortie",
                    "stock_disponible",
                    "seuil_alert",
                    "create_by",
                    "updated_by",
                    "date_maj",
                    "date_creation"
                ]
            ];

            // ===============================
            // 8. Entrepôts DB
            // ===============================
            $db = BaseBD::obtenir();
            $entrepots = $db->tous("SELECT id, nom FROM entrepots");

            // ===============================
            // 9. Réponse finale
            // ===============================
            return json_encode([
                "status" => "success",
                "columns" => $columns,
                "preview" => $preview,
                "tables" => $tables,
                "entrepots" => $entrepots,
                "temp_file" => $tempFileName,
                "total_rows" => count($rows) - 1,
                "errors" => $errors
            ]);
        } catch (\Exception $e) {

            return json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
    public function entrepots(Requete $requete, Reponse $response)
    {
        try {
            $db = BaseBD::obtenir();
            $entrepots = $db->tous("SELECT id, nom FROM entrepots");

            return $response->json([
                "status" => "success",
                "entrepots" => $entrepots
            ]);
        } catch (\Exception $e) {
            return $response->json([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
    public function preview(Requete $requete, Reponse $response): string
    {
        try {

            $donnees = $requete->tousCorps();

            $tempFile = $donnees['temp_file'] ?? null;
            $mapping = $donnees['mapping'] ?? [];
            $table = $donnees['table'] ?? null;

            if (!$tempFile || !$mapping || !$table) {
                return json_encode([
                    "status" => "error",
                    "message" => "Configuration invalide"
                ]);
            }

            $tempPath = StorageManager::chemin('temp/' . $tempFile);

            if (!file_exists($tempPath)) {
                return json_encode([
                    "status" => "error",
                    "message" => "Fichier temporaire introuvable"
                ]);
            }

            $data = json_decode(file_get_contents($tempPath), true);

            if (!$data) {
                return json_encode([
                    "status" => "error",
                    "message" => "Données invalides"
                ]);
            }

            $columns = $data['columns'];
            $rows = $data['rows'];

            // ===============================
            // 🔥 Champs obligatoires par table
            // ===============================
            $requiredFields = [
                "stock" => ["article_id", "entrepot_id"],
                "mouvement" => ["produit_id", "quantite", "type"]
            ];

            $required = $requiredFields[$table] ?? [];

            $preview = [];
            $errors = 0;

            foreach (array_slice($rows, 0, 20) as $rowIndex => $row) {

                $formatted = [];
                $rowErrors = [];
                $isValid = true;

                foreach ($mapping as $dbField => $excelCol) {

                    // 🔥 IGNORER non mappé
                    if (empty($excelCol)) continue;

                    // colonne existe ?
                    if (!in_array($excelCol, $columns)) continue;

                    $index = array_search($excelCol, $columns);
                    $value = $row[$index] ?? null;

                    // nettoyage simple
                    if (is_string($value)) {
                        $value = trim($value);
                    }

                    // ===============================
                    // 🔥 VALIDATION
                    // ===============================

                    // requis
                    if (in_array($dbField, $required) && ($value === null || $value === "")) {
                        $isValid = false;
                        $rowErrors[] = "$dbField requis";
                    }

                    // numeric
                    if (in_array($dbField, ["quantite", "prix", "stock_initial", "stock_entree", "stock_sortie"])) {
                        if ($value !== null && $value !== "" && !is_numeric($value)) {
                            $isValid = false;
                            $rowErrors[] = "$dbField doit être numérique";
                        }
                    }

                    // type mouvement
                    if ($dbField === "type" && $value) {
                        $allowed = ["entree", "sortie"];
                        if (!in_array(strtolower($value), $allowed)) {
                            $isValid = false;
                            $rowErrors[] = "type invalide (entree/sortie)";
                        }
                    }

                    $formatted[$dbField] = $value;
                }

                $preview[] = [
                    "row" => $rowIndex + 1,
                    "data" => $formatted,
                    "status" => $isValid ? "VALIDE" : "ERREUR",
                    "errors" => $rowErrors
                ];

                if (!$isValid) $errors++;
            }

            return json_encode([
                "status" => "success",
                "rows" => $preview,
                "errors" => $errors,
                "total_preview" => count($preview)
            ]);
        } catch (\Exception $e) {
            return json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
    public function execute(Requete $requete, Reponse $response): string
    {
        try {

            $donnees = $requete->tousCorps();

            $tempFile = $donnees['temp_file'] ?? null;
            $mapping = $donnees['mapping'] ?? [];
            $table = $donnees['table'] ?? null;
            $entrepotId = $donnees['entrepot_id'] ?? null;

            if (!$tempFile || !$mapping || !$table) {
                return json_encode([
                    "status" => "error",
                    "message" => "Configuration invalide"
                ]);
            }

            $tempPath = StorageManager::chemin('temp/' . $tempFile);

            if (!file_exists($tempPath)) {
                return json_encode([
                    "status" => "error",
                    "message" => "Fichier temporaire introuvable"
                ]);
            }

            $data = json_decode(file_get_contents($tempPath), true);

            $columns = $data['columns'];
            $rows = $data['rows'];

            $db = BaseBD::obtenir();

            // ===============================
            // 🔥 Champs obligatoires
            // ===============================
            $requiredFields = [
                "stock" => ["article_id", "entrepot_id"],
                "mouvement" => ["produit_id", "quantite", "type"]
            ];

            $required = $requiredFields[$table] ?? [];

            $success = 0;
            $errors = 0;
            $errorRows = [];

            // ===============================
            // 🔁 LOOP INSERT
            // ===============================
            foreach ($rows as $index => $row) {

                $formatted = [];
                $isValid = true;
                $rowErrors = [];

                foreach ($mapping as $dbField => $excelCol) {

                    // ignorer non mappé
                    if (empty($excelCol)) continue;

                    if (!in_array($excelCol, $columns)) continue;

                    $colIndex = array_search($excelCol, $columns);
                    $value = $row[$colIndex] ?? null;

                    if (is_string($value)) {
                        $value = trim($value);
                    }

                    // ================= VALIDATION =================

                    if (in_array($dbField, $required) && ($value === null || $value === "")) {
                        $isValid = false;
                        $rowErrors[] = "$dbField requis";
                    }

                    if (in_array($dbField, ["quantite", "prix", "stock_initial", "stock_entree", "stock_sortie"])) {
                        if ($value !== null && $value !== "" && !is_numeric($value)) {
                            $isValid = false;
                            $rowErrors[] = "$dbField doit être numérique";
                        }
                    }

                    // if ($dbField === "type" && $value) {
                    //     $allowed = ["entree", "sortie"];
                    //     if (!in_array(strtolower($value), $allowed)) {
                    //         $isValid = false;
                    //         $rowErrors[] = "type invalide";
                    //     }
                    // }

                    $formatted[$dbField] = $value;
                }

                // 🔥 ajouter entrepot si nécessaire
                if ($table === "stock" && $entrepotId) {
                    $formatted["entrepot_id"] = $entrepotId;
                }

                // ================= INSERT =================
                if ($isValid && count($formatted) > 0) {

                    $fields = array_keys($formatted);
                    $placeholders = array_map(fn($f) => ":$f", $fields);

                    $sql = "INSERT INTO $table (" . implode(",", $fields) . ")
                        VALUES (" . implode(",", $placeholders) . ")";

                    try {
                        $db->executer($sql, $formatted);
                        $success++;
                    } catch (\Exception $e) {
                        $errors++;
                        $errorRows[] = [
                            "row" => $index + 1,
                            "error" => $e->getMessage()
                        ];
                    }
                } else {
                    $errors++;
                    $errorRows[] = [
                        "row" => $index + 1,
                        "error" => $rowErrors
                    ];
                }
            }

            // ===============================
            // 🧹 supprimer fichier temporaire
            // ===============================
            unlink($tempPath);

            return json_encode([
                "status" => "success",
                "message" => "Import terminé",
                "inserted" => $success,
                "failed" => $errors,
                "errors_detail" => array_slice($errorRows, 0, 20) // limiter
            ]);
        } catch (\Exception $e) {

            return json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
}
