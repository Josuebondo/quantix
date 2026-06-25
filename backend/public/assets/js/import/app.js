let currentStep = 1;
let fileUploaded = false;
let importData = null;

// ================= ELEMENTS =================
const btnNext = document.getElementById("btn-next");
const btnPrev = document.getElementById("btn-prev");
const uploadZone = document.getElementById("upload-zone");
const fileReady = document.getElementById("file-ready");
const fileInput = document.getElementById("fileInput");
const nextText = document.getElementById("next-text");
const nextIcon = document.getElementById("next-icon");
const footer = document.getElementById("footer-actions");
const stepperItems = document.querySelectorAll(".step-nav");

const mappingBody = document.getElementById("mapping-body");
const selects = document.querySelectorAll("select");

// ================= TOAST =================
function toast(message, type = "info") {
  const colors = {
    success: "bg-emerald-500",
    error: "bg-rose-500",
    info: "bg-zinc-700",
  };

  const div = document.createElement("div");
  div.className = `${colors[type]} text-white px-4 py-2 rounded-lg shadow-lg fixed bottom-5 right-5 z-50 animate-fade`;
  div.innerText = message;

  document.body.appendChild(div);

  setTimeout(() => div.remove(), 3000);
}

// ================= UI =================
function updateUI() {
  document.querySelectorAll(".step-content").forEach((el, idx) => {
    el.classList.toggle("active", idx + 1 === currentStep);
  });

  stepperItems.forEach((item, idx) => {
    const stepNum = idx + 1;
    const textSpan = item.querySelector("span");

    if (stepNum === currentStep) {
      textSpan.className =
        "text-violet-400 border-b-2 border-violet-500 pb-4 mt-1";
    } else if (stepNum < currentStep) {
      textSpan.className = "text-emerald-400 pb-4 mt-1";
    } else {
      textSpan.className = "text-zinc-400 pb-4 mt-1";
    }
  });

  if (currentStep === 1) btnPrev.classList.add("opacity-50");
  else btnPrev.classList.remove("opacity-50");

  if (currentStep === 3) {
    nextText.textContent = "Importer";
    nextIcon.textContent = "upload_file";
  } else {
    nextText.textContent = "Suivant";
    nextIcon.textContent = "arrow_forward";
  }

  if (currentStep === 4) footer.classList.add("translate-y-full");
}

// ================= UPLOAD =================
uploadZone.addEventListener("click", () => fileInput.click());

fileInput.addEventListener("change", async (e) => {
  const file = e.target.files[0];
  if (!file) return;

  fileUploaded = true;

  fileReady.classList.remove("hidden");
  uploadZone.classList.add("border-emerald-500/50", "bg-emerald-500/5");

  toast("Fichier uploadé", "success");

  await sendFileToBackend(file);
});

// ================= API ANALYZE =================
async function sendFileToBackend(file) {
  nextText.textContent = "Analyse...";

  let formData = new FormData();
  formData.append("file", file);

  try {
    const res = await fetch("/api/import/analyze", {
      method: "POST",
      body: formData,
    });

    const data = await res.json();

    if (data.status !== "success") {
      toast(data.message, "error");
      return;
    }

    importData = data;
    loadConfiguration(data);

    currentStep = 2;
    updateUI();

    toast("Analyse terminée", "success");
  } catch (err) {
    toast("Erreur upload", "error");
    console.error(err);
  }
}

// ================= CONFIG =================
function loadConfiguration(data) {
  const entrepotSelect = selects[0];
  const tableSelect = selects[1];

  // Entrepots
  entrepotSelect.innerHTML = data.entrepots
    .map((e) => `<option value="${e.id}">${e.nom}</option>`)
    .join("");

  // Tables
  tableSelect.innerHTML = Object.keys(data.tables)
    .map((t) => `<option value="${t}">${t}</option>`)
    .join("");

  // événement changement table
  tableSelect.addEventListener("change", () => {
    renderMapping(tableSelect.value);
  });

  // premier rendu
  renderMapping(tableSelect.value);
}

// ================= AUTO MAP =================
function autoMap(field, columns) {
  field = field.toLowerCase();

  return columns.find((col) =>
    col.toLowerCase().includes(field.replace("_id", "")),
  );
}

// ================= MAPPING =================
function renderMapping(tableName) {
  const dbFields = importData.tables[tableName];
  const excelColumns = importData.columns;

  mappingBody.innerHTML = "";

  dbFields.forEach((field) => {
    const matched = autoMap(field, excelColumns);

    let selectHTML = "";

    // cas special entrepot
    if (field === "entrepot_id") {
      selectHTML = `
        <select class="mapping-select bg-zinc-900 border-zinc-800 text-xs rounded-lg w-full">
          ${importData.entrepots
            .map((e) => `<option value="${e.id}">${e.nom}</option>`)
            .join("")}
        </select>
      `;
    } else {
      selectHTML = `
        <select class="mapping-select bg-zinc-900 border-zinc-800 text-xs rounded-lg w-full" data-field="${field}">
          <option value="">-- choisir --</option>
          ${excelColumns
            .map(
              (col) =>
                `<option ${
                  col === matched ? "selected" : ""
                } value="${col}">${col}</option>`,
            )
            .join("")}
        </select>
      `;
    }

    const row = document.createElement("tr");

    row.innerHTML = `
      <td class="px-6 py-4 text-sm font-semibold text-zinc-200">
        ${field}
      </td>
      <td class="px-6 py-4 text-center">→</td>
      <td class="px-6 py-4">${selectHTML}</td>
    `;

    mappingBody.appendChild(row);
  });
}

// ================= GET MAPPING =================
function getMapping() {
  const mapping = {};

  document.querySelectorAll(".mapping-select").forEach((select) => {
    const field = select.dataset.field;
    if (field) {
      mapping[field] = select.value;
    }
  });

  return mapping;
}

// ================= PREVIEW =================
async function loadPreview() {
  const table = selects[1].value;
  const entrepot = selects[0].value;

  const config = {
    table,
    entrepot_id: entrepot,
    mapping: getMapping(),
    temp_file: importData.temp_file,
  };

  const res = await fetch("/api/import/preview", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(config),
  });

  const data = await res.json();

  renderPreview(data);
  toast("Preview chargé", "success");
}

function renderPreview(data) {
  const tbody = document.querySelector("#preview-body");
  const thead = document.querySelector("#preview-head");

  tbody.innerHTML = "";
  thead.innerHTML = "";

  if (!data.rows || data.rows.length === 0) return;

  const fields = Object.keys(data.rows[0].data);

  // HEADERS
  let headHTML = "<tr>";
  fields.forEach((f) => {
    headHTML += `<th class="p-3">${f}</th>`;
  });
  headHTML += `<th class="p-3">Statut</th></tr>`;

  thead.innerHTML = headHTML;

  // ROWS
  data.rows.forEach((row) => {
    let tr = `<tr class="hover:bg-zinc-800/20 ${
      row.status === "ERREUR" ? "text-rose-400" : ""
    }">`;

    fields.forEach((f) => {
      tr += `<td class="p-3">${row.data[f] ?? "--"}</td>`;
    });

    tr += `<td class="p-3">
        <span class="${
          row.status === "VALIDE" ? "text-emerald-500" : "text-rose-500"
        } font-bold">${row.status}</span>
      </td>`;

    tr += "</tr>";

    tbody.innerHTML += tr;
  });
}

// ================= IMPORT =================
async function startImport() {
  const table = selects[1].value;
  const entrepot = selects[0].value;

  const config = {
    table,
    entrepot_id: entrepot,
    mapping: getMapping(),
    temp_file: importData.temp_file,
  };

  const res = await fetch("/api/import/execute", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(config),
  });

  const result = await res.json();
  console.log(result);
  document.getElementById("loading-state").classList.add("hidden");
  document.getElementById("success-state").classList.remove("hidden");

  toast("Import réussi 🚀", "success");
}

// ================= NAVIGATION =================
btnNext.addEventListener("click", async () => {
  if (currentStep === 1 && !fileUploaded) {
    toast("Choisis un fichier", "error");
    return;
  }

  if (currentStep === 2) {
    await loadPreview();
  }

  if (currentStep === 3) {
    currentStep++;
    updateUI();
    startImport();
    return;
  }

  if (currentStep < 4) {
    currentStep++;
    updateUI();
  }
});

btnPrev.addEventListener("click", () => {
  if (currentStep > 1) {
    currentStep--;
    updateUI();
  }
});

// INIT
updateUI();
