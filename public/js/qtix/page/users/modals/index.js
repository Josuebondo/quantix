import { inviteUserModal } from "./invite-user.js";
import { createRoleModal } from "./create-role.js";

export function registerUserModals() {
  window.inviteUserModal = inviteUserModal;

  window.createRoleModal = createRoleModal;
}
