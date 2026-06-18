import Qtix from "../../../qtix.js";
import { createModal } from "../../../components/modal.js";

export function createRoleModal() {
  return {
    ...createModal({
      name: "create-role",

      title: "Créer un rôle",

      size: "xl",
    }),

    form: {
      name: "",

      description: "",

      permissions: [],
    },

    async submit() {
      await Qtix.post("/roles", this.form);

      Qtix.success("Rôle créé");

      this.close();
    },
  };
}
