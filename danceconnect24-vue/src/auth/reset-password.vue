<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-form">
        <h2>Reset Password</h2>
        <div class="home-input">
          <label>Password*</label>
          <input type="password" placeholder="Password*" v-model="password" />
        </div>
        <div class="home-input">
          <label>Confirm Password*</label>
          <input
            type="password"
            placeholder="Confirm Password*"
            v-model="passwordConfirmation"
          />
        </div>
        <div class="home-button">
          <button class="home-btn" @click="resetPassword">
            <p>Reset Password</p>
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
import MainHeader from "@main-components/main-header.vue";
import MainFooter from "@main-components/main-footer.vue";
import axios from "axios";

export default {
  components: {
    MainHeader,
    MainFooter,
  },
  data() {
    return {
      password: "",
      passwordConfirmation: "",
      token: "", // Add this to store the reset token
    };
  },
  mounted() {
    // Extract the token from the URL query parameters
    this.token = this.$route.query.token || ""; // Adjust according to your token query parameter
  },
  methods: {
    async resetPassword() {
      if (this.password !== this.passwordConfirmation) {
        alert("Passwords do not match.");
        return;
      }

      try {
        const response = await axios.post(
          "http://localhost:8000/authentication/reset-password",
          {
            token: this.token,
            password: this.password,
            password_confirmation: this.passwordConfirmation, // Send password confirmation
          }
        );

        alert(response.data.message);
        this.$router.push("/login");
      } catch (error) {
        if (error.response && error.response.status === 400) {
          alert("Invalid token.");
        } else if (error.response && error.response.status === 422) {
          alert("Please fill in the required fields.");
        } else {
          console.error("Reset password error:", error);
        }
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.home {
  width: 100%;
  padding-top: 100px;

  background: url("@bg/bg-1.png");
  background-repeat: no-repeat;
  background-position-x: 100%;
  .home-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: center;
    .home-form {
      width: 30%;
      border-radius: 15px;
      padding: 1rem;
      box-shadow: var(--box-shadow);
      margin-bottom: 2rem;
      background-color: var(--white);
      h2 {
        font-size: 24px;
        font-weight: 400;
        color: var(--black);
        margin-bottom: 1rem;
      }
      .home-input {
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
          border: none;
          border-bottom: 1px solid var(--pink);
          font-size: 16px;
          color: var(--black);
          margin-bottom: 1rem;
          margin-top: 1rem;
        }
      }
      .home-button {
        .home-btn {
          background-color: var(--pink);
          width: 100%;
          height: 40px;
          border: 2px solid var(--pink);
          border-radius: 5px;
          cursor: pointer;
          transition: 0.5s;
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 1rem;
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
              color: var(--pink);
            }
            svg {
              path {
                stroke: var(--pink);
              }
            }
          }
        }
      }
      .home-links {
        display: flex;
        flex-direction: column;
        a:not(:last-child) {
          margin-bottom: 1rem;
        }
        a {
          color: var(--black);
          text-decoration: none;
          transition: 0.5s;
          &:hover {
            color: var(--purple);
          }
        }
      }
    }
  }
}
@media screen and (max-width: 1200px) {
  .home {
    background: none;
    .home-content {
      width: 90%;
      .home-form {
        width: 100%;
      }
    }
  }
}
</style>
