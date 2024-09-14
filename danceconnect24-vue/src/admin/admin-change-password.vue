<template>
  <AdminHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h2>My account:</h2>
        <p>Nickname: {{ userNickname }}</p>
        <p>E-mail: {{ userEmail }}</p>
        <p>All classes: {{ totalClasses }}</p>
        <p>All clients: {{ totalClients }}</p>
      </div>
      <div class="home-right">
        <h2>Change Password</h2>
        <div class="home-right-input">
          <label>Current E-mail*</label>
          <input
            type="text"
            placeholder="Current E-mail*"
            v-model="currentEmail"
          />
        </div>
        <div class="home-right-input">
          <label>Password*</label>
          <input
            type="password"
            placeholder="Password*"
            v-model="currentPassword"
          />
        </div>
        <div class="home-right-input">
          <label>New Password*</label>
          <input
            type="password"
            placeholder="New Password*"
            v-model="newPassword"
          />
        </div>
        <div class="home-right-input">
          <label>Confirm New Password*</label>
          <input
            type="password"
            placeholder="Confirm New Password*"
            v-model="confirmNewPassword"
          />
        </div>
        <div class="home-right-button">
          <button class="home-right-btn" @click="changePassword">
            <p>Change Password</p>
            <svg
              width="22"
              height="19"
              viewBox="0 0 22 19"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M3.45067 10.9082L10.4033 17.4395C10.6428 17.6644 10.7625 17.7769 10.9037 17.8046C10.9673 17.8171 11.0327 17.8171 11.0963 17.8046C11.2375 17.7769 11.3572 17.6644 11.5967 17.4395L18.5493 10.9082C20.5055 9.07059 20.743 6.0466 19.0978 3.92607L18.7885 3.52734C16.8203 0.99058 12.8696 1.41601 11.4867 4.31365C11.2913 4.72296 10.7087 4.72296 10.5133 4.31365C9.13037 1.41601 5.17972 0.990584 3.21154 3.52735L2.90219 3.92607C1.25695 6.0466 1.4945 9.07059 3.45067 10.9082Z"
                stroke-width="2"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <MainFooter />
</template>

<script>
import AdminHeader from "@admin-components/admin-header.vue";
import MainFooter from "@main-components/main-footer.vue";
import axios from "axios";

export default {
  components: {
    AdminHeader,
    MainFooter,
  },
  data() {
    return {
      currentEmail: "",
      currentPassword: "",
      newPassword: "",
      confirmNewPassword: "",

      userNickname: "",
      userEmail: "",
      totalClients: 0,
      totalClasses: 0,
    };
  },
  methods: {
    async access() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        await axios.post("http://localhost:8000/authentication/admin-access");
      } catch (error) {
        this.$router.push("/login");
      }
    },
    async fetchCounts() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const [clientsResponse, classesResponse] = await Promise.all([
          axios.get("http://localhost:8000/admin/count-clients"),
          axios.get("http://localhost:8000/admin/count-classes"),
        ]);

        this.totalClients = clientsResponse.data.count;
        this.totalClasses = classesResponse.data.count;
      } catch (error) {
        console.error("Failed to fetch counts:", error);
      }
    },
    async fetchUserDetails() {
      this.userNickname = localStorage.getItem("nickname") || "";
      this.userEmail = localStorage.getItem("email") || "";
    },
    async changePassword() {
      if (this.newPassword !== this.confirmNewPassword) {
        alert("Passwords do not match");
        return;
      }

      const token = localStorage.getItem("token");
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      try {
        const response = await axios.post(
          "http://localhost:8000/school/change-password",
          {
            current_email: this.currentEmail,
            current_password: this.currentPassword,
            new_password: this.newPassword,
            new_password_confirmation: this.confirmNewPassword, // Dodaj to pole, aby pasowało do walidacji
          }
        );
        alert(response.data.message);

        // Reset the input fields
        this.currentEmail = "";
        this.currentPassword = "";
        this.newPassword = "";
        this.confirmNewPassword = "";
      } catch (error) {
        alert(error.response.data.error || "An error occurred");
      }
    },
  },
  mounted() {
    this.access();
    this.fetchCounts();
    this.fetchUserDetails();
  },
};
</script>

<style lang="scss" scoped>
.home {
  .home-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: space-between;
    padding-top: 100px;
    .home-left {
      width: calc(50% - 1rem);
      padding: 1rem;
      box-shadow: var(--box-shadow);
      border-radius: 15px;
      height: 100%;
      h2 {
        font-size: 24px;
        color: var(--black);
        font-weight: 500;
        margin-bottom: 1rem;
      }
      p:not(:last-child) {
        margin-bottom: 1rem;
      }
      p {
        font-size: 16px;
        color: var(--black);
        font-weight: 400;
      }
    }
    .home-right {
      width: calc(50% - 1rem);
      padding: 1rem;
      box-shadow: var(--box-shadow);
      border-radius: 15px;
      height: 100%;
      h2 {
        font-size: 24px;
        color: var(--black);
        font-weight: 500;
        margin-bottom: 1rem;
      }
      .home-right-input {
        display: flex;
        flex-direction: column;
        label {
          font-size: 16px;
          font-weight: 500;
          color: var(--black);
        }
        input {
          width: 100%;
          height: 40px;
          margin-top: 1rem;
          margin-bottom: 1rem;
          font-size: 16px;
          border: none;
          border-bottom: 1px solid var(--purple);
        }
      }
      .home-right-button {
        .home-right-btn {
          background-color: var(--purple);
          width: 100%;
          height: 40px;
          border: 2px solid var(--purple);
          border-radius: 5px;
          cursor: pointer;
          transition: 0.5s;
          display: flex;
          justify-content: space-between;
          align-items: center;
          p {
            font-size: 16px;
            font-weight: 500;
            color: var(--white);
            margin-left: 0.5rem;
            margin-top: 0; /* Usunięcie domyślnego marginesu górnego */
            margin-bottom: 0; /* Usunięcie domyślnego marginesu dolnego */
            line-height: 40px;
          }
          svg {
            margin-right: 0.5rem;
            path {
              stroke: var(--white);
            }
          }
          &:hover {
            background-color: var(--white);
            p {
              color: var(--purple);
            }
            svg {
              path {
                stroke: var(--purple);
              }
            }
          }
        }
      }
    }
  }
}

@media screen and (max-width: 1200px) {
  .home {
    .home-content {
      flex-direction: column;
      .home-left {
        width: 100%;
        margin-bottom: 2rem;
      }
      .home-right {
        width: 100%;
      }
    }
  }
}
</style>
