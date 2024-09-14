<template>
  <MainHeader />
  <div class="contact">
    <div class="contact-content">
      <div class="contact-form">
        <div class="contact-left">
          <h2>Informations:</h2>
          <p>Company name: DanceApp24</p>
          <p>Phone number: +97 1523891376</p>
          <p>E-mail: contact.danceapp24@gmail.com</p>
        </div>
        <div class="contact-right">
          <h2>Contact with Us!</h2>
          <div class="contact-input-flex">
            <input type="text" placeholder="Name*" v-model="formData.name" />
            <input
              type="text"
              placeholder="Surname*"
              v-model="formData.surname"
            />
          </div>
          <div class="contact-input-flex">
            <input type="text" placeholder="E-mail*" v-model="formData.email" />
            <input
              type="text"
              placeholder="Phone number*"
              v-model="formData.phone"
            />
          </div>
          <div class="contact-input-full-width">
            <textarea
              placeholder="Message"
              v-model="formData.message"
            ></textarea>
          </div>
          <div class="contact-terms">
            <input type="checkbox" v-model="formData.acceptTerms" />
            <p>
              I accept <a href="#"> the regulations</a> and
              <a href="#">policy privacy.</a> (Required)
            </p>
          </div>
          <div class="contact-buttons">
            <button class="contact-btn" @click="sendForm">
              <p>Send</p>
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
            <button class="contact-btn" @click="clearFields">
              <p>Reset</p>
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
      formData: {
        name: "",
        surname: "",
        email: "",
        phone: "",
        message: "",
        acceptTerms: false,
      },
    };
  },
  methods: {
    sendForm() {
      if (
        this.formData.name &&
        this.formData.surname &&
        this.formData.email &&
        this.formData.phone &&
        this.formData.message
      ) {
        if (this.formData.acceptTerms) {
          axios
            .post("http://localhost:8000/main/contact", this.formData)
            .then((response) => {
              alert("Message send, we will contact with you!");
              this.clearFields();
            })
            .catch((error) => {
              console.error(error);
            });
        } else {
          alert("You have to accept regulations and policy privacy.");
        }
      } else {
        alert("All fields are required.");
      }
    },
    clearFields() {
      this.formData.name = "";
      this.formData.surname = "";
      this.formData.email = "";
      this.formData.phone = "";
      this.formData.message = "";
      this.formData.acceptTerms = false;
    },
  },
};
</script>

<style lang="scss" scoped>
.contact {
  width: 100%;
  padding-top: 100px;

  background: url("@bg/bg-1.png");
  background-repeat: no-repeat;
  background-position-x: 100%;
  .contact-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: center;
    .contact-form {
      width: 65%;
      background-color: var(--white);
      border: 1px solid var(--pink);
      border-radius: 15px;
      display: flex;
      justify-content: space-between;
      .contact-left {
        width: 50%;
        padding: 2rem;
        border-right: 1px solid var(--pink);
        background: url("@assets/contact-logo.png");
        background-repeat: no-repeat;
        background-position: center;
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
      .contact-right {
        width: 50%;
        padding: 2rem;
        h2 {
          font-size: 24px;
          color: var(--black);
          font-weight: 500;
          margin-bottom: 1rem;
        }
        .contact-input-flex {
          display: flex;
          justify-content: space-between;
          margin-bottom: 1rem;
          input {
            height: 40px;
            width: calc(50% - 0.5rem);
            border: none;
            padding-left: 1rem;
            font-size: 16px;
            border-bottom: 1px solid var(--pink);
          }
        }
        .contact-input-full-width {
          margin-bottom: 1rem;
          textarea {
            width: 100%;
            height: 140px;
            resize: none;
            border: none;
            padding-top: 1rem;
            padding-left: 1rem;
            font-size: 16px;
            border-bottom: 1px solid var(--pink);
          }
        }
        .contact-terms {
          display: flex;
          align-items: center;
          margin-bottom: 1rem;
          input {
            margin-right: 1rem;
            width: 15px;
            height: 15px;
            cursor: pointer;
          }
          p {
            font-size: 16px;
            font-weight: 400;
            color: var(--black);
            a {
              color: var(--pink);
              text-decoration: none;
              transition: 0.5s;
              &:hover {
                color: var(--purple);
              }
            }
          }
        }
      }
      .contact-buttons {
        display: flex;
        .contact-btn:last-child {
          background-color: var(--white);
          width: 240px;
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
            color: var(--pink);
            margin-left: 0.5rem;
            margin-top: 0; /* Usunięcie domyślnego marginesu górnego */
            margin-bottom: 0; /* Usunięcie domyślnego marginesu dolnego */
            line-height: 40px;
          }
          svg {
            margin-right: 0.5rem;
            path {
              stroke: var(--pink);
            }
          }
          &:hover {
            background-color: var(--pink);
            p {
              color: var(--white);
            }
            svg {
              path {
                stroke: var(--white);
              }
            }
          }
        }
        .contact-btn:first-child {
          background-color: var(--pink);
          width: 240px;
          height: 40px;
          border: 2px solid var(--pink);
          border-radius: 5px;
          cursor: pointer;
          transition: 0.5s;
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-right: 1rem;

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
  .contact {
    background: none;
    .contact-content {
      .contact-form {
        width: 100%;
        flex-direction: column;
        .contact-left {
          width: 100%;
          padding: 1rem;
        }
        .contact-right {
          width: 100%;
          padding: 1rem;
          .contact-input-flex {
            flex-direction: column;
            margin-bottom: 0;
            input {
              width: 100%;
              margin-bottom: 1rem;
            }
          }
          .contact-buttons {
            flex-direction: column;
            .contact-btn:first-child {
              width: 100%;
              margin-bottom: 1rem;
            }
            .contact-btn:last-child {
              width: 100%;
            }
          }
        }
      }
    }
  }
}
</style>
