import Qtix from "../../../qtix.js";
import { createModal } from "../../../components/modal.js";

export function inviteUserModal() {
  return {
    ...createModal({
      name: "invite-user",

      title: "Inviter un utilisateur",

      size: "lg",
    }),

    form: {
      email: "",

      role_id: "",

      warehouse_id: "",
    },

    async submit() {
      try {
        this.loading = true;

        await Qtix.post("/users/invite", this.form);

        Qtix.success("Invitation envoyée");

        this.close();
      } finally {
        this.loading = false;
      }
    },
  };
}
