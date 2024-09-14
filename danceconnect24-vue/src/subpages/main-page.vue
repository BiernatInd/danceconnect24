<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h1>Dance with Simplicity:</h1>
        <h2>Book, Pay, and Schedule Hassle-Free</h2>
        <p>
          Optimize Your Dance Studio Business with Our Platform: Streamline your
          operations, increase efficiency, and boost revenue effortlessly. Our
          user-friendly interface makes booking, payment, and scheduling a
          breeze, allowing you to focus on what you love – teaching dance.
          Maximize your studio's potential, minimize administrative headaches –
          it's time to elevate your dance experience--
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
        <img src="@assets/img-1.png" alt="" />
      </div>
    </div>
  </div>

  <MainPlugin />

  <div class="banner">
    <div class="banner-content">
      <img src="@assets/banner.png" alt="" />
    </div>
  </div>

  <div class="find">
    <div class="find-content">
      <div class="find-text">
        <h2>Fing dance studio</h2>
      </div>
      <div class="find-box">
        <div class="find-item">
          <h2>JAMES AND ALEX</h2>
        </div>
        <div class="find-item">
          <h2>DANCE STUDIO EMILIA</h2>
        </div>
        <div class="find-item">
          <h2>DANCE STUDIO DUBAI</h2>
        </div>
      </div>
    </div>
  </div>

  <div class="price">
    <div class="price-content">
      <div class="price-top">
        <h2>Price list</h2>
      </div>
      <div class="price-bottom">
        <div class="price-bottom-item-box">
          <h2>Dance</h2>
          <div class="price-bottom-item">
            <p>Price per hour approximately</p>
            <p>80 AED</p>
          </div>
          <div class="price-bottom-item">
            <p>In the package</p>
            <p>70 AED</p>
          </div>
        </div>
        <div class="price-bottom-item-box">
          <h2>Private dance</h2>
          <div class="price-bottom-item">
            <p>Rates are AED 300 for 1 hour class</p>
          </div>
          <div class="price-bottom-item">
            <p>AED 2,700 for 10 hours classe</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="dance">
    <div class="dance-content">
      <div class="dance-left">
        <div class="dance-item">
          <h2>Unleash <span>Your Dance</span> Journey:</h2>
          <p>
            Our platform seamlessly connects passionate dancers with top-tier
            dance schools, offering a dynamic space where creativity meets
            convenience. Easily discover and book your spot in classes taught by
            your favorite instructors, breaking down barriers and fostering a
            vibrant dance community. Whether you're a beginner or a seasoned
            dancer, our user-friendly interface empowers you to explore diverse
            dance styles, schedule classes at your convenience, and elevate your
            skills with ease. Connect, create, and dance your way to excellence,
            all on our platform designed to harmonize your dance experience
          </p>
          <div class="dance-item-button">
            <button class="dance-item-btn">
              <p>Join us now</p>
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
        <div class="dance-item">
          <h2>Ready to Dance? Join Us Today!</h2>
          <p>
            Download DanceApp24 now and unleash your inner dancer. Get started
            on your path to mastering the art of dance and let the rhythm guide
            you to new heights of creativity and expression. Join us as we dance
            our way to joy, passion, and endless possibilities
          </p>
          <div class="dance-item-button">
            <button class="dance-item-btn">
              <p>Join us now</p>
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
      <div class="dance-right">
        <img src="@assets/banner-2.png" alt="" />
      </div>
    </div>
  </div>
  <MainFooter />
  <MainCookies />
</template>

<script>
import MainHeader from "@main-components/main-header.vue";
import MainPlugin from "@main-components/main-plugin.vue";
import MainFooter from "@main-components/main-footer.vue";
import MainCookies from "@main-components/main-cookies.vue";

export default {
  components: {
    MainHeader,
    MainPlugin,
    MainFooter,
    MainCookies,
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
  height: 810px;
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
        font-weight: 600;
        margin-bottom: 2rem;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
      }
      h2 {
        font-size: 32px;
        font-weight: 400;
        margin-bottom: 2rem;
        color: var(--black);
      }
      p {
        margin-bottom: 2rem;
        font-size: 20px;
        font-weight: 400;
        color: var(--black);
      }
      .home-left-buttons {
        display: flex;
        .home-left-btn:first-child {
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
          margin-right: 2rem;
          p {
            font-size: 16px;
            font-weight: 500;
            color: var(--pink);
            margin-left: 0.5rem;
            margin-top: 0;
            margin-bottom: 0;
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
        .home-left-btn:last-child {
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
      width: calc(27% - 1rem);
      img {
        display: block;
        width: 100%;
        height: 100%;
      }
    }
  }
}

.banner {
  .banner-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    padding-top: 100px;
    img {
      display: block;
      width: 100%;
      border-radius: 15px;
    }
  }
}

.find {
  .find-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    padding-top: 100px;
    .find-text {
      margin-bottom: 2rem;
      h2 {
        font-size: 40px;
        font-weight: 600;
        color: var(--black);
      }
    }
    .find-box {
      display: flex;
      justify-content: space-between;
      .find-item {
        padding: 4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gradient);
        border-radius: 15px;
        h2 {
          font-size: 40px;
          color: var(--white);
          max-width: 400px;
          text-align: center;
        }
      }
    }
  }
}
.price {
  .price-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    padding-top: 100px;
    .price-top {
      width: 100%;
      border-radius: 15px;
      padding: 1rem;
      box-shadow: var(--box-shadow);
      margin-bottom: 2rem;
      h2 {
        font-size: 24px;
        font-weight: 500;
        text-align: center;
        color: var(--black);
      }
    }
    .price-bottom {
      display: flex;
      justify-content: space-between;
      .price-bottom-item-box {
        width: calc(50% - 1rem);
        padding: 1rem;
        box-shadow: var(--box-shadow);
        border-radius: 15px;
        h2 {
          font-size: 24px;
          color: var(--black);
          font-weight: 500;
          margin-bottom: 1rem;
        }
        .price-bottom-item:not(:last-child) {
          margin-bottom: 1rem;
        }
        .price-bottom-item {
          display: flex;
          justify-content: space-between;
          padding-bottom: 1rem;
          border-bottom: 1px solid var(--pink);
          p {
            color: var(--black);
          }
        }
      }
    }
  }
}

.dance {
  .dance-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    padding-top: 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    .dance-left {
      width: calc(60% - 1rem);
      .dance-item:not(:last-child) {
        margin-bottom: 2rem;
      }
      .dance-item {
        padding: 1rem;
        background-color: var(--white);
        box-shadow: var(--box-shadow);
        border-radius: 15px;
        h2 {
          font-size: 24px;
          font-weight: 500;
          margin-bottom: 1rem;
          color: var(--black);
        }
        p {
          font-size: 16px;
          color: var(--black);
          font-weight: 400;
          margin-bottom: 1rem;
        }
        .dance-item-button {
          .dance-item-btn:first-child {
            background-color: var(--purple);
            width: 240px;
            height: 40px;
            border: 2px solid var(--purple);
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
              margin-top: 0;
              margin-bottom: 0;
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
    .dance-right {
      width: calc(40% - 1rem);

      img {
        display: block;
        width: 100%;
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
  .banner {
    .banner-content {
      width: 90%;

      padding-top: 2rem;
      img {
        width: 100%;
      }
    }
  }
  .find {
    .find-content {
      width: 90%;

      padding-top: 2rem;
      .find-text {
        h2 {
          font-size: 24px;
        }
      }
      .find-box {
        flex-direction: column;
        .find-item {
          width: 100%;
          margin-bottom: 2rem;
          h2 {
            max-width: 100%;
            font-size: 20px;
          }
        }
      }
    }
  }
  .price {
    .price-content {
      padding-bottom: 2rem;
      padding-top: 0;
      width: 90%;

      .price-top {
        h2 {
          font-size: 24px;
        }
      }
      .price-bottom {
        flex-direction: column;
        .price-bottom-item-box:not(:last-child) {
          margin-bottom: 2rem;
        }
        .price-bottom-item-box {
          width: 100%;
          h2 {
            font-size: 24px;
          }
          .price-bottom-item {
            width: 100%;
            p {
              font-size: 16px;
            }
          }
        }
      }
    }
  }
}
</style>
