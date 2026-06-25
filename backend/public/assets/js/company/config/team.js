import Qtix from "/js/qtix/qtix.js";

window.teamPage = {
  users: [],

  async init() {
    const data = await Qtix.get("/api/team");

    this.users = data.users;
  },

  openInviteModal() {
    alert("modal");
  },
};
