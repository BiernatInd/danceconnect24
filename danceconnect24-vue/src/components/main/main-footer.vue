<template>
  <div class="footer">
    <div class="footer-content">
      <div class="footer-top">
        <div class="footer-col">
          <router-link to="/">Main Page</router-link>
          <router-link to="/about-us">About Us</router-link>
          <router-link to="/price">Pricing</router-link>
          <router-link to="/offer-for-schools">Offer for schools</router-link>
          <router-link to="/calendar">Class schedule</router-link>
          <router-link to="/buy-school-account">Buy School Account</router-link>
        </div>
        <div class="footer-col">
          <router-link to="/login">Sign in</router-link>
          <router-link to="/register">Sign up</router-link>
          <router-link to="/contact">Contact</router-link>
          <router-link to="/policy-privacy">Policy Privacy</router-link>
          <router-link to="/regulations">Regulations</router-link>
        </div>
        <div class="footer-col">
          <h2>Social media:</h2>
          <div class="footer-col-social">
            <img src="@icons/fb-icon.svg" alt="" />
            <a href="https://www.facebook.com/danceapp24" target="_blank"
              >DANCE APP 24</a
            >
          </div>
          <div class="footer-col-social">
            <img src="@icons/ig-icon.svg" alt="" />
            <a href="https://www.instagram.com/danceapp24/" target="_blank"
              >danceapp24</a
            >
          </div>
          <div class="footer-col-social">
            <img src="@icons/ln-icon.svg" alt="" />
            <a
              href="https://www.linkedin.com/company/danceapp24/"
              target="_blank"
              >DanceAPP24</a
            >
          </div>
          <div class="footer-col-social">
            <img src="@icons/tk-icon.svg" alt="" />
            <a href="https://www.tiktok.com/@danceapp24" target="_blank"
              >Danceapp24</a
            >
          </div>
        </div>
        <div class="footer-col">
          <p>Contact:</p>
          <p>Phone number: +97 1523891376</p>
          <p>E-mail: contact.danceapp24@gmail.com</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>
          Copyright © 2024
          <a href="https://karolbiernat.pl" target="_blank">Karol Biernat.</a>
          All rights deserved.
        </p>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.footer {
  .footer-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    .footer-top {
      display: flex;
      justify-content: space-between;
      padding-top: 100px;

      padding-bottom: 100px;
      .footer-col:nth-child(1) {
        border-left: 1px solid var(--pink);
        border-right: 1px solid var(--pink);
      }
      .footer-col:nth-child(2) {
        border-right: 1px solid var(--pink);
      }
      .footer-col:nth-child(3) {
        border-right: 1px solid var(--pink);
      }
      .footer-col:nth-child(4) {
        border-right: 1px solid var(--pink);
      }
      .footer-col {
        width: 25%;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        a:not(:last-child) {
          margin-bottom: 1rem;
        }
        a {
          text-decoration: none;
          color: var(--black);
          font-weight: 400;
          font-size: 16px;
        }
        h2 {
          color: var(--black);
          font-weight: 400;
          font-size: 16px;
          margin-bottom: 1rem;
        }
        p:not(:last-child) {
          margin-bottom: 1rem;
        }
        .footer-col-social:not(:last-child) {
          margin-bottom: 1rem;
        }
        .footer-col-social {
          display: flex;
          align-items: center;
          img {
            margin-right: 1rem;
          }
          a {
            color: var(--black);
            transition: 0.5s;
            &:hover {
              color: var(--pink);
            }
          }
        }
      }
    }
    .footer-bottom {
      border-top: 1px solid var(--pink);
      padding: 1rem;
      p {
        text-align: center;
        a {
          text-decoration: none;
          color: var(--black);
          transition: 0.5s;
          cursor: pointer;
          &:hover {
            color: var(--pink);
          }
        }
      }
    }
  }
}

@media screen and (max-width: 1200px) {
  .footer {
    .footer-content {
      .footer-top {
        flex-direction: column;
        padding-bottom: 0;
        padding-top: 2rem;

        .footer-col {
          width: 100%;
        }
        .footer-col:nth-child(1) {
          border-left: 0;
          border-right: 0;
          border-top: 1px solid var(--pink);
          border-bottom: 1px solid var(--pink);
        }
        .footer-col:nth-child(2) {
          border-right: 0;
          border-bottom: 1px solid var(--pink);
        }
        .footer-col:nth-child(3) {
          border-right: 0;
          border-bottom: 1px solid var(--pink);
        }
        .footer-col:nth-child(4) {
          border-right: 0;
          border-bottom: 1px solid var(--pink);
        }
      }
      .footer-bottom {
        border-top: 0;
        p {
          text-align: start;
        }
      }
    }
  }
}
</style>
