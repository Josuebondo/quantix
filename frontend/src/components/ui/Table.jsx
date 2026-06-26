import { cn } from "../../utils/cn";

export default function Table({
  columns = [],
  rows = [],
  className,
  emptyLabel = "Aucune donnée",
}) {
  return (
    <div
      className={cn(
        "overflow-x-auto rounded-xl border border-outline-variant",
        className,
      )}
    >
      <table className="min-w-full border-collapse text-sm">
        <thead className="bg-surface-container">
          <tr>
            {columns.map((column) => (
              <th
                key={column.key}
                className="px-4 py-3 text-left font-semibold text-on-surface"
              >
                {column.label}
              </th>
            ))}
          </tr>
        </thead>
        <tbody>
          {rows.length === 0 ? (
            <tr>
              <td
                colSpan={Math.max(columns.length, 1)}
                className="px-4 py-8 text-center text-on-surface-variant"
              >
                {emptyLabel}
              </td>
            </tr>
          ) : (
            rows.map((row, index) => (
              <tr
                key={row.id ?? index}
                className="border-t border-outline-variant/70"
              >
                {columns.map((column) => (
                  <td
                    key={column.key}
                    className="px-4 py-3 text-on-surface-variant"
                  >
                    {column.render
                      ? column.render(row[column.key], row)
                      : row[column.key]}
                  </td>
                ))}
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
}
