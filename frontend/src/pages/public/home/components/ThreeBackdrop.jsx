import { useEffect, useRef } from "react";
import * as THREE from "three";
import { useAppStore } from "../../../../store/useAppStore";

function cssColorToHex(value) {
  const match = value.trim().match(/rgba?\((\d+)[, ]+(\d+)[, ]+(\d+)/i);

  if (!match) {
    return 0x10b981;
  }

  const red = Number(match[1]);
  const green = Number(match[2]);
  const blue = Number(match[3]);

  return (red << 16) | (green << 8) | blue;
}

export default function ThreeBackdrop({
  className = "",
  count = 12,
  perspective = 900,
  mobileCount = 8,
  intensity = 0.75,
}) {
  const theme = useAppStore((state) => state.theme);
  const containerRef = useRef(null);

  useEffect(() => {
    const container = containerRef.current;

    if (!container) {
      return undefined;
    }

    const styles = getComputedStyle(document.documentElement);
    const primaryColor = styles.getPropertyValue("--primary") || "78 222 163";
    const secondaryColor =
      styles.getPropertyValue("--secondary") || "208 188 255";
    const tertiaryColor =
      styles.getPropertyValue("--tertiary") || "255 179 175";
    const onSurfaceColor =
      styles.getPropertyValue("--on-surface") || "212 228 250";
    const backgroundColor =
      styles.getPropertyValue("--background") || "5 20 36";

    const primaryHex = cssColorToHex(`rgb(${primaryColor})`);
    const secondaryHex = cssColorToHex(`rgb(${secondaryColor})`);
    const tertiaryHex = cssColorToHex(`rgb(${tertiaryColor})`);
    const onSurfaceHex = cssColorToHex(`rgb(${onSurfaceColor})`);
    const backgroundHex = cssColorToHex(`rgb(${backgroundColor})`);

    const width = container.clientWidth || window.innerWidth;
    const height = container.clientHeight || window.innerHeight;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, width / height, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });

    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x000000, 0);
    renderer.setAnimationLoop(null);
    container.appendChild(renderer.domElement);

    const group = new THREE.Group();
    scene.add(group);

    const geometry = new THREE.BoxGeometry(1, 1, 1);
    const materials = [
      new THREE.MeshPhongMaterial({
        color: primaryHex,
        shininess: 90,
        transparent: true,
        opacity: 0.72 * intensity,
        emissive: primaryHex,
        emissiveIntensity: theme === "dark" ? 0.28 : 0.18,
      }),
      new THREE.MeshPhongMaterial({
        color: secondaryHex,
        shininess: 85,
        transparent: true,
        opacity: 0.58 * intensity,
        emissive: secondaryHex,
        emissiveIntensity: theme === "dark" ? 0.16 : 0.1,
      }),
      new THREE.MeshPhongMaterial({
        color: tertiaryHex,
        shininess: 80,
        transparent: true,
        opacity: 0.5 * intensity,
        emissive: tertiaryHex,
        emissiveIntensity: theme === "dark" ? 0.14 : 0.08,
      }),
    ];

    const isMobile = window.innerWidth < 768;
    const instanceCount = isMobile ? mobileCount : count;

    for (let index = 0; index < instanceCount; index += 1) {
      const material = materials[index % materials.length];
      const mesh = new THREE.Mesh(geometry, material);
      mesh.position.set(
        (Math.random() - 0.5) * (isMobile ? 7 : 12),
        (Math.random() - 0.5) * (isMobile ? 7 : 12),
        (Math.random() - 0.5) * 6,
      );
      mesh.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, 0);
      mesh.scale.setScalar(Math.random() * 0.42 + 0.18);
      group.add(mesh);
    }

    const ambientLight = new THREE.AmbientLight(
      onSurfaceHex,
      theme === "dark" ? 0.42 : 0.5,
    );
    scene.add(ambientLight);

    const pointLight = new THREE.PointLight(
      primaryHex,
      theme === "dark" ? 1.5 : 1.1,
    );
    pointLight.position.set(4, 4, 6);
    scene.add(pointLight);

    const accentLight = new THREE.PointLight(
      secondaryHex,
      theme === "dark" ? 0.9 : 0.7,
    );
    accentLight.position.set(-5, -2, 4);
    scene.add(accentLight);

    scene.background = null;
    camera.position.z = isMobile ? 8 : 7;

    let animationFrameId = 0;

    const animate = () => {
      animationFrameId = window.requestAnimationFrame(animate);
      group.rotation.y += 0.0011;
      group.rotation.x += 0.00055;

      group.children.forEach((child, index) => {
        child.position.y += Math.sin(Date.now() * 0.001 + index) * 0.002;
        child.rotation.z += 0.0045;
      });

      renderer.render(scene, camera);
    };

    const handleResize = () => {
      const nextWidth = container.clientWidth || window.innerWidth;
      const nextHeight = container.clientHeight || window.innerHeight;
      camera.aspect = nextWidth / nextHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(nextWidth, nextHeight);
    };

    window.addEventListener("resize", handleResize);
    animate();

    return () => {
      window.removeEventListener("resize", handleResize);
      window.cancelAnimationFrame(animationFrameId);
      geometry.dispose();
      materials.forEach((material) => material.dispose());
      renderer.dispose();
      if (container.contains(renderer.domElement)) {
        container.removeChild(renderer.domElement);
      }
    };
  }, [count, intensity, mobileCount, perspective, theme]);

  return (
    <div
      ref={containerRef}
      aria-hidden="true"
      className={`pointer-events-none ${className}`}
      style={{ perspective: `${perspective}px` }}
    />
  );
}
