<?php

/**
 * ======================================================================
 * Routes Web - Framework BMVC Production
 * ======================================================================
 */

use Core\Middlewares\MiddlewareJWTAuth;
use Core\Routeur;
use Core\Middlewares\MiddlewareAuth;
use Core\Middlewares\MiddlewareCSRF;

// ======== Routes Publiques ========
// Route accueil
Routeur::obtenir('/', 'AccueilControleur@index')->nom('accueil');

// Route page de démarrage
Routeur::obtenir('/demarrage', 'DémarrageControlleur@index')->nom('démarrage');

// Route page de documentation
Routeur::obtenir('/documentation', 'DocumentationControleur@index')->nom('documentation');

// Route page de connexion
Routeur::obtenir('/login', 'AuthControleur@index')->nom('login');
Routeur::obtenir('/logout', 'AuthControleur@logout')->nom('logout');
Routeur::obtenir('/get-started', 'AuthControleur@sighin')->nom('register');
Routeur::obtenir('/company/register', 'AuthControleur@registerCompanyPage')->nom('company.register');
Routeur::publier('/company/send-activation', 'AuthControleur@sendActivationEmail')->middleware(MiddlewareCSRF::class)->nom('company.send-activation');

Routeur::obtenir('/company/activate', 'CompanyController@activate')->nom('company.activate');
Routeur::publier('/company/activate', 'CompanyController@activation')->nom('company.activate.post');
Routeur::obtenir('/company/configuration', 'CompanyController@configurationInitiale')->nom('company.configuration');


// ======== API Authentication Endpoints ========
Routeur::publier('/api/auth/login', 'AuthControleur@apiLogin')->nom('api.auth.login');
Routeur::publier('/api/auth/register', 'AuthControleur@apiRegister')->nom('api.auth.register');
Routeur::publier('/api/auth/register-company', 'AuthControleur@apiRegisterCompany')->nom('api.auth.register-company');
Routeur::publier('/api/auth/refresh', 'AuthControleur@apiRefresh')->nom('api.auth.refresh');
Routeur::obtenir('/api/auth/verify', 'AuthControleur@apiVerify')->middleware(MiddlewareJWTAuth::class)->nom('api.auth.verify');
Routeur::publier('/api/auth/logout', 'AuthControleur@apiLogout')->middleware(MiddlewareJWTAuth::class)->nom('api.auth.logout');

// ======== Routes Protégées (JWT) ========
Routeur::obtenir('/mouvements', 'MouvementControleur@index')->middleware(MiddlewareAuth::class)->nom('mouvement');
// document
Routeur::obtenir('/documents', 'documentControleur@index')->middleware(MiddlewareAuth::class)->nom('document');
Routeur::obtenir('/documents/creer', 'documentControleur@creer')->nom('document.creer');
Routeur::publier('/documents/creer', 'documentControleur@enregistrer')->nom('document.envoyer');
Routeur::obtenir('/documents/{id}/editer', 'documentControleur@editer')->ou('id', '[0-9]+')->nom('document.editer');
Routeur::publier('/documents/{id}/editer', 'documentControleur@mettreAJour')->ou('id', '[0-9]+')->nom('document.mettre');
Routeur::obtenir('/documents/{id}/supprimer', 'documentControleur@supprimer')->ou('id', '[0-9]+')->nom('document.supprimer');
Routeur::publier('/document', 'documentControleur@store');
Routeur::obtenir('/document/brouillons', 'documentControleur@brouillons');

//route inventaire
Routeur::obtenir('/inventaire', 'documentControleur@inv')->nom('inventaire');
// article
Routeur::obtenir('/articles', 'articleControleur@index')->nom('article');

//api 
Routeur::obtenir('/api/articles', 'articleControleur@getAll')->nom('article.api');




Routeur::obtenir('/dashboard', 'dashboardControleur@index')->nom('dashbord.gerent');
Routeur::obtenir('/test', 'dashboardControleur@test')->nom('dashbord.test');
// versement
Routeur::obtenir('/versements', 'versementControleur@index')->nom('versement');
Routeur::obtenir('/api/versement', 'versementControleur@all')->nom('versement');
Routeur::publier('/api/versement', 'versementControleur@store')->nom('versement');


//folder 
Routeur::obtenir('/folder', 'FolderControler@index');
Routeur::obtenir('/importer', 'importControler@index');
Routeur::publier('/api/import/analyze', 'importControler@analyze')->nom('import.analyze');
Routeur::publier('/api/import/preview', 'importControler@preview')->nom('import.preview');
Routeur::publier('/api/import/execute', 'importControler@execute')->nom('import.execute');

Routeur::tous('/entrepot/liste', 'importControler@entrepots');
Routeur::obtenir('/tester', 'testControleur@index')->nom('test');
// Plan
Routeur::obtenir('/plans', 'PlanControleur@index')->nom('plan');
Routeur::obtenir('/plans/creer', 'PlanControleur@creer')->nom('plan.creer');
Routeur::publier('/plans/creer', 'PlanControleur@enregistrer')->nom('plan.envoyer');
Routeur::obtenir('/plans/{id}/editer', 'PlanControleur@editer')->ou('id', '[0-9]+')->nom('plan.editer');
Routeur::publier('/plans/{id}/editer', 'PlanControleur@mettreAJour')->ou('id', '[0-9]+')->nom('plan.mettre');
Routeur::obtenir('/plans/{id}/supprimer', 'PlanControleur@supprimer')->ou('id', '[0-9]+')->nom('plan.supprimer');

// ======== ONBOARDING WIZARD ROUTES ========
// Welcome page after activation
Routeur::obtenir('/welcome', 'CompanyController@welcome')->middleware(MiddlewareAuth::class)->nom('welcome');

// Wizard initialization & resumption
Routeur::publier('/api/wizard/init', 'CompanyController@wizardInit')->middleware(MiddlewareAuth::class)->nom('api.wizard.init');
Routeur::obtenir('/workspace/setup', 'CompanyController@configurationInitiale')->middleware(MiddlewareAuth::class)->nom('wizard.setup');
Routeur::obtenir('/api/wizard/resume', 'CompanyController@wizardResume')->middleware(MiddlewareAuth::class)->nom('api.wizard.resume');

// Wizard state management
Routeur::publier('/api/wizard/autosave', 'CompanyController@wizardAutosave')
    ->middleware([MiddlewareCSRF::class, MiddlewareAuth::class])
    ->nom('api.wizard.autosave');

Routeur::publier('/api/wizard/deploy', 'CompanyController@wizardDeploy')->middleware(MiddlewareAuth::class)->nom('api.wizard.deploy');

// Wizard helper endpoints
Routeur::obtenir('/api/wizard/permissions', 'CompanyController@wizardPermissions')->middleware(MiddlewareAuth::class)->nom('api.wizard.permissions');
Routeur::publier('/api/wizard/generate-sku', 'CompanyController@wizardGenerateSku')->middleware(MiddlewareAuth::class)->nom('api.wizard.generate-sku');

// Activation endpoint
Routeur::publier('/api/company/activate', 'CompanyController@apiActivate')->nom('api.company.activate');
