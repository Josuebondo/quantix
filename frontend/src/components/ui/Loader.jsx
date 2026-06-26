export default function Loader({ size = 48, className = "", ...props }) {
  const styles =
    typeof size === "number"
      ? { width: `${size}px`, height: `${size}px` }
      : { width: size, height: size };

  return (
    <div
      className={`inline-flex items-center justify-center shrink-0 ${className}`}
      style={styles}
      aria-hidden="true"
      {...props}
    >
      <svg
        viewBox="0 0 300 300"
        className="w-full h-full"
        xmlns="http://www.w3.org/2000/svg"
      >
        <defs>
          <linearGradient id="qGradient" x1="0%" y1="100%" x2="100%" y2="0%">
            <stop offset="0%" stopColor="#0a1d42" />
            <stop offset="35%" stopColor="#1d4ed8" />
            <stop offset="70%" stopColor="#2563eb" />
            <stop offset="100%" stopColor="#38bdf8" />
          </linearGradient>

          <linearGradient id="tailGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stopColor="#1e40af" />
            <stop offset="40%" stopColor="#2563eb" />
            <stop offset="100%" stopColor="#38bdf8" />
          </linearGradient>

          <linearGradient id="cubeTop" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stopColor="#38bdf8" />
            <stop offset="100%" stopColor="#2563eb" />
          </linearGradient>

          <linearGradient id="cubeLeft" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stopColor="#09111f" />
            <stop offset="100%" stopColor="#17253d" />
          </linearGradient>

          <linearGradient id="cubeRight" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="100%" stopColor="#0a1d42" />
            <stop offset="0%" stopColor="#1d4ed8" />
          </linearGradient>
        </defs>

        <g stroke="url(#qGradient)" fill="none" strokeLinecap="square">
          <path
            d="M80 120 L45 120"
            strokeWidth="7"
            className="speed-element group-1"
          />
          <circle
            cx="33"
            cy="120"
            r="3.5"
            fill="url(#qGradient)"
            stroke="none"
            className="dot-element group-1"
          />

          <path
            d="M72 138 L30 138"
            strokeWidth="7"
            className="speed-element group-2"
          />
          <circle
            cx="18"
            cy="138"
            r="3.5"
            fill="url(#qGradient)"
            stroke="none"
            className="dot-element group-2"
          />

          <path
            d="M78 156 L40 156"
            strokeWidth="7"
            className="speed-element group-3"
          />
          <circle
            cx="28"
            cy="156"
            r="3.5"
            fill="url(#qGradient)"
            stroke="none"
            className="dot-element group-3"
          />
        </g>

        <circle
          cx="150"
          cy="150"
          r="85"
          fill="none"
          stroke="url(#qGradient)"
          strokeWidth="24"
          strokeLinecap="square"
          className="q-circle"
        />

        <polygon
          points="188,188 204,172 266,252 232,252"
          fill="url(#tailGradient)"
          className="q-tail"
        />

        <g className="q-cubes">
          <g transform="translate(150,110)">
            <polygon points="0,-16 18,-7 0,2 -18,-7" fill="url(#cubeTop)" />
            <polygon points="-18,-7 0,2 0,18 -18,9" fill="url(#cubeLeft)" />
            <polygon points="0,2 18,-7 18,9 0,18" fill="url(#cubeRight)" />
          </g>

          <g transform="translate(130,140)">
            <polygon points="0,-16 18,-7 0,2 -18,-7" fill="url(#cubeTop)" />
            <polygon points="-18,-7 0,2 0,18 -18,9" fill="url(#cubeLeft)" />
            <polygon points="0,2 18,-7 18,9 0,18" fill="url(#cubeRight)" />
          </g>

          <g transform="translate(170,140)">
            <polygon points="0,-16 18,-7 0,2 -18,-7" fill="url(#cubeTop)" />
            <polygon points="-18,-7 0,2 0,18 -18,9" fill="url(#cubeLeft)" />
            <polygon points="0,2 18,-7 18,9 0,18" fill="url(#cubeRight)" />
          </g>
        </g>
      </svg>
    </div>
  );
}
