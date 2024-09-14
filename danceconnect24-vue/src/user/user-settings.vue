<template>
  <UserHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h2>My account</h2>
        <p>Nickname: {{ nickname }}</p>
        <p>E-mail: {{ email }}</p>
      </div>
      <div class="home-right">
        <h2>Change data</h2>
        <div class="home-right-buttons">
          <button class="home-right-btn" @click="redirectToUserChangeEmail">
            <p>Change E-mail</p>
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
          <button class="home-right-btn" @click="redirectToUserChangePassword">
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
          <button class="home-right-btn" @click="showConfirmation">
            <p>Delete Account</p>
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

  <div class="confirmation" :class="{ active: isConfirmationActive }">
    <div class="confirmation-content">
      <h2>Deleting an account</h2>
      <p>Are you sure you want to delete your user account?</p>
      <div class="confirmation-button">
        <button class="confirmation-btn" @click="hideConfirmation">
          Cancel
        </button>
        <button class="confirmation-btn" @click="showDelete">
          Delete your account
        </button>
      </div>
    </div>
  </div>
  <MainFooter />
</template>

<script>
import UserHeader from "@user-components/user-header.vue";
import MainFooter from "@main-components/main-footer.vue";
import axios from "axios";

export default {
  components: {
    UserHeader,
    MainFooter,
  },
  data() {
    return {
      isConfirmationActive: false,
      nickname: "",
      email: "",
    };
  },
  methods: {
    showConfirmation() {
      this.isConfirmationActive = true;
    },
    hideConfirmation() {
      this.isConfirmationActive = false;
    },
    async access() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        await axios.post("http://localhost:8000/authentication/user-access");
      } catch (error) {
        this.$router.push("/login");
      }
    },
    redirectToUserChangeEmail() {
      this.$router.push("/user-change-email");
    },
    redirectToUserChangePassword() {
      this.$router.push("/user-change-password");
    },
    async showDelete() {
      try {
        const userId = localStorage.getItem("userId");
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        await axios.post("http://localhost:8000/user/delete", {
          user_id: userId, // Zmieniono na user_id
        });
        localStorage.clear(); // Wyczyść localStorage
        this.$router.push("/"); // Przekieruj na stronę główną
      } catch (error) {
        console.error("Error deleting account:", error);
        // Możesz dodać odpowiednie powiadomienie dla użytkownika
      }
    },
  },
  mounted() {
    this.access();

    this.nickname = localStorage.getItem("nickname");
    this.email = localStorage.getItem("email");
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
      .home-right-buttons {
        display: flex;
        flex-direction: column;
        .home-right-btn:not(:last-child) {
          margin-bottom: 1rem;
        }
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

.confirmation {
  background-color: rgba(0, 0, 0, 0.2);
  position: fixed;
  width: 1920px;
  max-width: 100%;
  height: 100%;
  top: -100%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.5s;
  &.active {
    top: 0;
  }
  .confirmation-content {
    width: 40%;
    background-color: var(--white);
    padding: 1rem;
    border-radius: 15px;
    h2 {
      font-size: 24px;
      color: var(--black);
      font-weight: 500;
      margin-bottom: 1rem;
    }
    p {
      font-size: 16px;
      color: var(--black);
      font-weight: 400;
      margin-bottom: 1rem;
    }
    .confirmation-button {
      display: flex;
      justify-content: space-between;
      .confirmation-btn:first-child {
        background-color: var(--purple);
        width: calc(50% - 1rem);
        height: 40px;
        border: 2px solid var(--purple);
        border-radius: 5px;
        cursor: pointer;
        transition: 0.5s;
        margin-bottom: 1rem;
        font-size: 16px;
        font-weight: 500;
        color: var(--white);
        &:hover {
          background-color: var(--white);
          color: var(--purple);
        }
      }
      .confirmation-btn:last-child {
        background-color: var(--white);
        width: calc(50% - 1rem);
        height: 40px;
        border: 2px solid var(--purple);
        border-radius: 5px;
        cursor: pointer;
        transition: 0.5s;
        margin-bottom: 1rem;
        font-size: 16px;
        font-weight: 500;
        color: var(--purple);
        &:hover {
          background-color: var(--purple);
          color: var(--white);
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
  .confirmation {
    .confirmation-content {
      width: 90%;
      .confirmation-button {
        flex-direction: column;
        .confirmation-btn:last-child {
          width: 100%;
        }
        .confirmation-btn:first-child {
          width: 100%;
          margin-bottom: 1rem;
        }
      }
    }
  }
}
</style>
