<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h1>About us:</h1>
        <p>
          Introducing DanceConnect24, the ultimate platform tailored for dance
          schools in the UAE, specifically in Dubai, to seamlessly manage
          reservations and streamline scheduling processes. Whether you run a
          traditional dance studio or offer specialized classes, DanceConnect
          empowers you to take control of your bookings while providing a
          convenient interface for your students.
        </p>
        <p>
          With DanceConnect, creating and managing your school's schedule has
          never been easier. Our intuitive interface allows you to customize
          class times, set availability, and update schedules effortlessly. Say
          goodbye to the hassle of manual booking systems and hello to a
          streamlined, digital solution designed to meet the unique needs of
          dance educators.
        </p>
        <p>
          But that's not all – DanceConnect goes beyond simple scheduling.
          Through our integration with DanceApp24, a popular application
          dedicated to dance enthusiasts, your school gains exposure to a wider
          audience. Potential students can discover your classes, read reviews,
          and book directly through the app, making it a powerful tool for both
          promotion and customer acquisition.
        </p>
        <p>
          Furthermore, DanceConnect extends its reach through active promotion
          on various social media channels. We understand the importance of
          visibility in today's digital age, which is why we leverage platforms
          like Instagram, Facebook, and Twitter to showcase your school,
          talented dancers, and upcoming events. By harnessing the power of
          social media, DanceConnect helps elevate your brand and attract
          attention from potential students across the UAE and beyond.
        </p>
        <p>
          Whether you're a well-established dance institution or just starting
          out, DanceConnect offers the tools and support you need to succeed in
          the competitive world of dance education. Join us today and experience
          the difference of a platform designed with your school's success in
          mind. Let DanceConnect be your partner in shaping the future of dance
          in Dubai.
        </p>
        <div class="home-left-buttons">
          <button class="home-left-btn" @click="redirectToLogin">
            <p>Log in to dance studio</p>
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
          <button class="home-left-btn" @click="redirectToLogin">
            <p>Log in dance student</p>
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
      <div class="home-right">
        <img src="@assets/img-2.png" alt="" />
      </div>
    </div>
  </div>
  <MainFooter />
</template>

<script>
import MainHeader from "@main-components/main-header.vue";
import MainFooter from "@main-components/main-footer.vue";

export default {
  components: {
    MainHeader,
    MainFooter,
  },
  methods: {
    redirectToLogin() {
      this.$router.push("/login");
    },
  },
};
</script>

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
      .home-left-buttons {
        display: flex;
        .home-left-btn:last-child {
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
        .home-left-btn:first-child {
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
          margin-right: 2rem;

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
        .home-left-buttons {
          display: flex;
          flex-direction: column;
          .home-left-btn:first-child {
            width: 100%;
            margin-bottom: 1rem;
          }
          .home-left-btn:last-child {
            width: 100%;
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
