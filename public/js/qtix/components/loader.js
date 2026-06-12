export const html = `<div class="w-full h-full max-w-[240px] max-h-[240px] aspect-square flex items-center justify-center">
                            <svg viewBox="0 0 300 300" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="qGradient" x1="0%" y1="100%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#0a1d42" />
                                        <stop offset="35%" stop-color="#1d4ed8" />
                                        <stop offset="70%" stop-color="#2563eb" />
                                        <stop offset="100%" stop-color="#38bdf8" />
                                    </linearGradient>

                                    <linearGradient id="tailGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#1e40af" />
                                        <stop offset="40%" stop-color="#2563eb" />
                                        <stop offset="100%" stop-color="#38bdf8" />
                                    </linearGradient>

                                    <linearGradient id="cubeTop" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#38bdf8" />
                                        <stop offset="100%" stop-color="#2563eb" />
                                    </linearGradient>
                                    <linearGradient id="cubeLeft" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stop-color="#09111f" />
                                        <stop offset="100%" stop-color="#17253d" />
                                    </linearGradient>
                                    <linearGradient id="cubeRight" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="100%" stop-color="#0a1d42" />
                                        <stop offset="0%" stop-color="#1d4ed8" />
                                    </linearGradient>
                                </defs>

                                <g stroke="url(#qGradient)" fill="none" stroke-linecap="square">
                                    <path d="M 80 120 L 45 120" stroke-width="7" class="speed-element group-1" />
                                    <circle cx="33" cy="120" r="3.5" fill="url(#qGradient)" stroke="none" class="dot-element group-1" />

                                    <path d="M 72 138 L 30 138" stroke-width="7" class="speed-element group-2" />
                                    <circle cx="18" cy="138" r="3.5" fill="url(#qGradient)" stroke="none" class="dot-element group-2" />

                                    <path d="M 78 156 L 40 156" stroke-width="7" class="speed-element group-3" />
                                    <circle cx="28" cy="156" r="3.5" fill="url(#qGradient)" stroke="none" class="dot-element group-3" />
                                </g>

                                <circle
                                    cx="150"
                                    cy="150"
                                    r="85"
                                    fill="none"
                                    stroke="url(#qGradient)"
                                    stroke-width="24"
                                    stroke-linecap="square"
                                    class="q-circle" />

                                <path
                                    d="M 194 194 L 252 252"
                                    stroke="url(#tailGradient)"
                                    stroke-width="24"
                                    stroke-linecap="square"
                                    fill="none"
                                    class="q-tail" />

                                <g class="q-cubes">
                                    <g transform="translate(150, 110)">
                                        <polygon points="0,-16 18,-7 0,2 -18,-7" fill="url(#cubeTop)" />
                                        <polygon points="-18,-7 0,2 0,18 -18,9" fill="url(#cubeLeft)" />
                                        <polygon points="0,2 18,-7 18,9 0,18" fill="url(#cubeRight)" />
                                    </g>
                                    <g transform="translate(130, 140)">
                                        <polygon points="0,-16 18,-7 0,2 -18,-7" fill="url(#cubeTop)" />
                                        <polygon points="-18,-7 0,2 0,18 -18,9" fill="url(#cubeLeft)" />
                                        <polygon points="0,2 18,-7 18,9 0,18" fill="url(#cubeRight)" />
                                    </g>
                                    <g transform="translate(170, 140)">
                                        <polygon points="0,-16 18,-7 0,2 -18,-7" fill="url(#cubeTop)" />
                                        <polygon points="-18,-7 0,2 0,18 -18,9" fill="url(#cubeLeft)" />
                                        <polygon points="0,2 18,-7 18,9 0,18" fill="url(#cubeRight)" />
                                    </g>
                                </g>
                            </svg>
                        </div>`;
