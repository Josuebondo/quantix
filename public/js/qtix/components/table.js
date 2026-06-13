/**
 * Table Component - Qtix
 * Composant table avec tri, pagination, recherche
 */

export function createTable(options = {}) {
  return {
    items: options.items || [],
    columns: options.columns || [],
    currentPage: 1,
    itemsPerPage: options.itemsPerPage || 10,
    sortBy: options.sortBy || null,
    sortOrder: "asc",
    searchQuery: "",
    selectedRows: new Set(),

    init() {
      this.items = options.items || [];
    },

    get filteredItems() {
      let filtered = [...this.items];

      // Recherche
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter((item) => {
          return Object.values(item).some((value) =>
            String(value).toLowerCase().includes(query),
          );
        });
      }

      // Tri
      if (this.sortBy) {
        filtered.sort((a, b) => {
          const aVal = a[this.sortBy];
          const bVal = b[this.sortBy];

          if (aVal < bVal) return this.sortOrder === "asc" ? -1 : 1;
          if (aVal > bVal) return this.sortOrder === "asc" ? 1 : -1;
          return 0;
        });
      }

      return filtered;
    },

    get paginatedItems() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredItems.slice(start, end);
    },

    get totalPages() {
      return Math.ceil(this.filteredItems.length / this.itemsPerPage);
    },

    get totalItems() {
      return this.filteredItems.length;
    },

    sort(columnName) {
      if (this.sortBy === columnName) {
        this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
      } else {
        this.sortBy = columnName;
        this.sortOrder = "asc";
      }
      this.currentPage = 1;
    },

    search(query) {
      this.searchQuery = query;
      this.currentPage = 1;
    },

    goToPage(page) {
      this.currentPage = Math.max(1, Math.min(page, this.totalPages));
    },

    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },

    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },

    toggleRow(id) {
      if (this.selectedRows.has(id)) {
        this.selectedRows.delete(id);
      } else {
        this.selectedRows.add(id);
      }
    },

    toggleAllRows() {
      if (this.selectedRows.size === this.paginatedItems.length) {
        this.selectedRows.clear();
      } else {
        this.paginatedItems.forEach((item) => {
          this.selectedRows.add(item.id);
        });
      }
    },

    getSelectedItems() {
      return this.items.filter((item) => this.selectedRows.has(item.id));
    },

    clearSelection() {
      this.selectedRows.clear();
    },
  };
}

/**
 * HTML Template pour Table
 */
export function renderTable(config) {
  const { id, columns, title } = config;
  return `
        <div id="${id}" x-data="${id}" class="w-full">
            <!-- Toolbar -->
            <div class="mb-4 flex items-center justify-between gap-4">
                <div class="flex-1">
                    <input 
                        type="text"
                        placeholder="Rechercher..."
                        @input="search($event.target.value)"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                    />
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span x-text="totalItems"></span> résultats
                </div>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white w-8">
                                <input type="checkbox" @change="toggleAllRows()" />
                            </th>
                            ${columns
                              .map(
                                (col) => `
                                <th 
                                    @click="sort('${col.key}')"
                                    class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-white cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700"
                                >
                                    <div class="flex items-center gap-2">
                                        ${col.label}
                                        <span 
                                            x-show="sortBy === '${col.key}'"
                                            class="material-symbols-outlined text-sm"
                                            x-text="sortOrder === 'asc' ? 'arrow_upward' : 'arrow_downward'"
                                        ></span>
                                    </div>
                                </th>
                            `,
                              )
                              .join("")}
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="item in paginatedItems" :key="item.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="px-4 py-3">
                                    <input 
                                        type="checkbox"
                                        :checked="selectedRows.has(item.id)"
                                        @change="toggleRow(item.id)"
                                    />
                                </td>
                                ${columns
                                  .map(
                                    (col) => `
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                        <span x-text="item['${col.key}']"></span>
                                    </td>
                                `,
                                  )
                                  .join("")}
                                <td class="px-4 py-3 text-right">
                                    <slot name="row-actions"></slot>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Page <span x-text="currentPage"></span> sur <span x-text="totalPages"></span>
                </div>
                <div class="flex gap-2">
                    <button 
                        @click="previousPage()"
                        :disabled="currentPage <= 1"
                        class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg disabled:opacity-50"
                    >
                        Précédent
                    </button>
                    <button 
                        @click="nextPage()"
                        :disabled="currentPage >= totalPages"
                        class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg disabled:opacity-50"
                    >
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    `;
}
