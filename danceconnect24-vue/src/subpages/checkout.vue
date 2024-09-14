<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h2>Enter your details</h2>
        <div class="home-input-flex">
          <input type="text" placeholder="Name*" v-model="name" />
          <input type="text" placeholder="Surname*" v-model="surname" />
        </div>
        <div class="home-input-flex">
          <input type="text" placeholder="E-mail*" v-model="email" />
          <input
            type="text"
            placeholder="Phone number*"
            v-model="phoneNumber"
          />
        </div>
        <div class="home-checkbox-flex">
          <div class="home-checkbox-item">
            <input
              type="checkbox"
              id="lady"
              :checked="sex === 'women'"
              @change="updateSex('women')"
            />
            <label for="lady">Lady</label>
          </div>
          <div class="home-checkbox-item">
            <input
              type="checkbox"
              id="mr"
              :checked="sex === 'men'"
              @change="updateSex('men')"
            />
            <label for="mr">Mr.</label>
          </div>
        </div>
        <div class="home-checkbox">
          <input
            type="checkbox"
            id="join-the-group"
            :checked="signUpType === 'group'"
            @change="updateSignUpType('group')"
          />
          <label for="join-the-group"
            >I sign up permanently and join the group</label
          >
        </div>
        <div class="home-checkbox">
          <input
            type="checkbox"
            id="one-off"
            :checked="signUpType === 'one_off'"
            @change="updateSignUpType('one_off')"
          />
          <label for="one-off">I'm signing up for one-off classes</label>
        </div>
        <div class="home-checkbox">
          <input
            type="checkbox"
            id="accept-regulations"
            v-model="acceptRegulations"
          />
          <p>
            I accept <a href="#">the regulations</a> and
            <a href="#">policy privacy.</a> (Required)
          </p>
        </div>
      </div>
      <div class="home-right">
        <h2>Summary</h2>
        <div class="home-right-item">
          <p>Class name:</p>
          <p>{{ className }}</p>
        </div>
        <div class="home-right-item">
          <p>Room number:</p>
          <p>{{ roomNumber }}</p>
        </div>
        <div class="home-right-item">
          <p>Date:</p>
          <p>{{ eventDate }}</p>
        </div>
        <div class="home-right-item">
          <p>Hours:</p>
          <p>{{ timeRange }}</p>
        </div>
        <div class="home-right-item">
          <p>Total price:</p>
          <p>{{ price }} AED</p>
        </div>
        <div class="home-right-button">
          <button class="home-right-btn" @click="sendCheckout">
            <p>Pay</p>
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

  <div class="thanks" v-if="showThanks">
    <div class="thanks-content">
      <div class="thanks-top">
        <img src="@icons/close.svg" alt="" />
      </div>
      <div class="thanks-text">
        <p>Thank you for placing your order.</p>
        <p>
          You can see detailed data in your account or at the e-mail address
          provided.
        </p>
      </div>
    </div>
  </div>
  <MainFooter />
</template>

<script>
import axios from "axios";
import MainHeader from "@main-components/main-header.vue";
import MainFooter from "@main-components/main-footer.vue";

export default {
  data() {
    return {
      name: "",
      surname: "",
      email: "",
      phoneNumber: "",
      sex: "", // 'women' or 'men'
      signUpType: "", // 'group' or 'one_off'
      acceptRegulations: false,
      className: "",
      roomNumber: "",
      timeRange: "",
      eventDate: "",
      price: "",
      showThanks: false,
    };
  },
  mounted() {
    // Pobierz dane z localStorage
    this.className = localStorage.getItem("className") || "N/A";
    this.roomNumber = localStorage.getItem("roomNumber") || "N/A";
    this.timeRange = localStorage.getItem("timeRange") || "N/A";
    this.eventDate = localStorage.getItem("eventDate") || "N/A";
    // Wywołaj metodę, aby pobrać cenę
    this.fetchClassPrice();
  },
  methods: {
    updateSex(value) {
      // Jeśli zaznaczono checkbox, zaktualizuj zmienną 'sex'
      if (this.sex === value) {
        this.sex = ""; // Odznacz
      } else {
        this.sex = value; // Zaznacz
      }
    },
    updateSignUpType(value) {
      // Jeśli zaznaczono checkbox, zaktualizuj zmienną 'signUpType'
      if (this.signUpType === value) {
        this.signUpType = ""; // Odznacz
      } else {
        this.signUpType = value; // Zaznacz
      }
    },
    async fetchClassPrice() {
      // Pobierz classesId z localStorage
      const classesId = localStorage.getItem("classesId");

      if (classesId) {
        try {
          // Wyślij zapytanie GET, aby pobrać cenę
          const response = await axios.get(`http://localhost:8000/main/price`, {
            params: { classesId },
          });
          // Zaktualizuj cenę w stanie komponentu
          this.price = response.data.price;
        } catch (error) {
          console.error(
            "An error occurred while fetching the class price:",
            error
          );
        }
      }
    },
    async sendCheckout() {
      // Sprawdź, czy regulamin został zaakceptowany
      if (!this.acceptRegulations) {
        alert("You must accept the regulations and privacy policy.");
        return; // Przerwij dalsze wykonanie, jeśli regulamin nie jest zaakceptowany
      }

      // Pobierz ClassesId i userId z localStorage
      const classesId = localStorage.getItem("classesId");
      const userId = localStorage.getItem("userId");

      // Przygotuj dane do wysłania
      const data = {
        name: this.name,
        surname: this.surname,
        email: this.email,
        phone: this.phoneNumber,
        sex: this.sex,
        signUpType: this.signUpType,
        classesId: classesId,
        price: this.price, // Dodaj cenę do danych
      };

      // Dodaj userId, jeśli istnieje w localStorage
      if (userId) {
        data.userId = userId;
      }

      // Wyświetl dane w konsoli
      console.log("Dane do wysłania:", data);

      try {
        // Wyślij zapytanie POST
        const response = await axios.post(
          "http://localhost:8000/main/checkout",
          data
        );
        alert("Dodano pomyślnie");
        this.showThankYou(); // Pokaż podziękowanie
      } catch (error) {
        // Sprawdź, czy błąd pochodzi z odpowiedzi serwera
        if (
          error.response &&
          error.response.data &&
          error.response.data.error
        ) {
          alert(error.response.data.error);
        } else {
          console.error("An error occurred while submitting the form:", error);
          alert("Please enter correct details");
        }
      }
    },
    showThankYou() {
      this.showThanks = true;
    },
  },
  components: {
    MainHeader,
    MainFooter,
  },
};
</script>

<style lang="scss" scoped>
.thanks {
  position: fixed;
  width: 100%;
  max-width: 1920px;
  height: 100%;
  top: -100%;
  background-color: rgba(0, 0, 0, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.5s;
  &:hover {
    top: 0;
  }
  .thanks-content {
    width: 80%;
    background-color: var(--white);
    border-radius: 15px;
    padding: 2rem;
    position: relative;
    .thanks-top {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 2rem;
      position: absolute;
      top: 1rem;
      right: 1rem;
      img {
        cursor: pointer;
      }
    }
    .thanks-text {
      p:not(:last-child) {
        margin-bottom: 0.5rem;
      }
      p {
        font-size: 28px;
        font-weight: 400;
        color: var(--black);
        text-align: center;
      }
    }
  }
}
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
    justify-content: space-between;
    .home-left {
      width: calc(60% - 1rem);
      background-color: var(--white);
      padding: 2rem;
      box-shadow: var(--box-shadow);
      border-radius: 15px;
      height: 100%;
      h2 {
        font-size: 24px;
        font-weight: 400;
        margin-bottom: 1rem;
      }
      .home-input-flex {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        input {
          width: calc(50% - 1rem);
          height: 40px;
          font-size: 16px;
          color: var(--black);
          border: none;
          border-bottom: 1px solid var(--pink);
        }
      }
      .home-checkbox-flex {
        display: flex;
        margin-bottom: 1rem;
        .home-checkbox-item {
          display: flex;
          align-items: center;
          margin-right: 1rem;
          input {
            width: 15px;
            height: 15px;
            margin-right: 1rem;
          }
          p {
            font-size: 16px;
          }
        }
      }
      .home-checkbox:not(:last-child) {
        margin-bottom: 1rem;
      }
      .home-checkbox {
        display: flex;
        align-items: center;
        input {
          width: 15px;
          height: 15px;
          margin-right: 1rem;
        }
        p {
          font-size: 16px;
          a {
            color: var(--pink);
            transition: 0.5s;
            cursor: pointer;
            text-decoration: none;
            &:hover {
              color: var(--purple);
            }
          }
        }
      }
    }
    .home-right {
      width: calc(40% - 1rem);
      background-color: var(--white);
      padding: 2rem;
      border-radius: 15px;
      box-shadow: var(--box-shadow);
      h2 {
        font-size: 24px;
        font-weight: 400;
        margin-bottom: 1rem;
      }
      .home-right-item {
        display: flex;
        justify-content: space-between;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--pink);
        margin-bottom: 1rem;
      }
      .home-right-button {
        .home-right-btn {
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
        margin-bottom: 2rem;
        padding: 1rem;
        .home-input-flex {
          margin-bottom: 0;
          flex-direction: column;
          input {
            width: 100%;
            margin-bottom: 1rem;
          }
        }
      }
      .home-right {
        width: 100%;
        padding: 1rem;
      }
    }
  }
  .thanks {
    .thanks-content {
      width: 90%;
      .thanks-text {
        padding-top: 2rem;
        p {
          font-size: 20px;
        }
      }
    }
  }
}
</style>
