<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h1>Buy school account:</h1>
        <p>
          Exciting news! For a limited time only, we're offering an exclusive
          discount on DanceConnect24 accounts for schools like yours. Take
          advantage of this special offer and revolutionize the way you manage
          your studio for just $499 per month, down from the regular price of
          $999.
        </p>
        <p>
          With DanceConnect24, you'll enjoy all the benefits of our premium
          studio management platform at a fraction of the cost. Say goodbye to
          the hassle of manual scheduling and reservations and hello to
          streamlined, efficient studio operations.
        </p>
        <p>
          But hurry – this offer won't last long! Don't miss your chance to
          upgrade your studio to DanceConnect24 and unlock a world of
          possibilities for growth and success. Sign up today and start
          experiencing the difference for your business.
        </p>
        <div class="home-box">
          <div class="home-input">
            <label>Nickname*</label>
            <input v-model="nickname" type="text" placeholder="Nickname*" />
          </div>
          <div class="home-input">
            <label>E-mail*</label>
            <input v-model="email" type="text" placeholder="E-mail*" />
          </div>
          <div class="home-box-button">
            <button class="home-box-btn" @click="submitForm">
              <p>Buy account</p>
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
      <div class="home-right">
        <img src="@/assets/img-2.png" alt="" />
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
      nickname: "",
      email: "",
      errorMessage: "",
      successMessage: "",
    };
  },
  methods: {
    async submitForm() {
      // Resetuj komunikaty
      this.errorMessage = "";
      this.successMessage = "";

      // Walidacja
      if (!this.nickname || !this.email) {
        this.errorMessage = "Nickname and email are required.";
        return;
      }

      // Debugowanie danych przed wysłaniem
      console.log("Sending data:", {
        nickname: this.nickname,
        email: this.email,
      });

      try {
        const response = await axios.post(
          "http://localhost:8000/main/buy-school-account",
          {
            nickname: this.nickname,
            email: this.email,
          }
        );

        this.successMessage = response.data.message;
        alert("Account created successfully, check your inbox.");
      } catch (error) {
        if (error.response && error.response.data) {
          this.errorMessage =
            error.response.data.error || "Failed to create account.";
          // Debugowanie błędów
          console.log("Error response:", error.response.data);
        } else {
          this.errorMessage = "Failed to create account.";
        }
      }
    },
  },
};
</script>

<style scoped>
/* Dodaj style według potrzeb */
</style>

<style lang="scss" scoped>
.home {
  width: 100%;
  padding-top: 100px;
  height: 100%;
  background: url("@bg/bg-1.png");
  background-repeat: no-repeat;
  background-position-x: 100%;
  .home-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    .home-left {
      width: calc(50% - 1rem);
      h1 {
        font-size: 40px;
        font-weight: 400;
        margin-bottom: 2rem;
        span {
          color: var(--pink);
        }
      }
      p {
        margin-bottom: 2rem;
        font-size: 20px;
        font-weight: 400;
        color: var(--black);
      }
      .home-box {
        .home-input {
          label {
            font-size: 20px;
            font-weight: 500;
            color: var(--black);
          }
          input {
            margin-top: 1rem;
            margin-bottom: 2rem;
            width: 100%;
            height: 40px;
            border: none;
            border-bottom: 1px solid var(--pink);
            font-size: 16px;
          }
        }
        .home-box-button {
          .home-box-btn:first-child {
            background-color: var(--pink);
            width: 100%;
            height: 60px;
            border: 2px solid var(--pink);
            border-radius: 5px;
            cursor: pointer;
            transition: 0.5s;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-right: 2rem;

            p {
              font-size: 20px;
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
      }
    }
    .home-right {
      width: calc(40% - 1rem);
      img {
        display: block;
        width: 100%;
        height: 100%;
      }
    }
  }
}

@media screen and (max-width: 1500px) {
  .home {
    height: 100%;
    .home-content {
      .home-right {
        margin-bottom: 2rem;
      }
    }
  }
}

@media screen and (max-width: 1200px) {
  .home {
    background: none;
    .home-content {
      width: 90%;
      flex-direction: column;
      .home-left {
        width: 100%;
        h1 {
          font-size: 24px;
          margin-bottom: 1rem;
        }
        p {
          font-size: 16px;
          margin-bottom: 1rem;
        }
        .home-box {
          .home-input {
            label {
              font-size: 16px;
            }
          }
          .home-box-button {
            .home-box-btn:first-child {
              height: 40px;
              margin-bottom: 2rem;
              p {
                font-size: 16px;
              }
            }
          }
        }
      }
      .home-right {
        width: 100%;
      }
    }
  }
}
</style>
