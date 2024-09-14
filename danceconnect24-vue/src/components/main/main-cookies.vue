<template>
  <div v-if="showCookieBanner" class="cookies">
    <div class="cookies-content">
      <p>
        By clicking "I Accept," you agree to the use of cookies by the website
        in accordance with the <a href="/policy-privacy">Policy Privacy</a> and
        <a href="/regulations">Regulations.</a>
      </p>
      <div class="cookies-button">
        <button class="cookies-btn" @click="acceptCookies">Accept</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showCookieBanner: false,
    };
  },
  methods: {
    acceptCookies() {
      this.setCookie("cookieConsent", "true", 365);
      this.showCookieBanner = false;
    },
    setCookie(name, value, days) {
      let expires = "";
      if (days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/";
    },
    getCookie(name) {
      const nameEQ = name + "=";
      const ca = document.cookie.split(";");
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
          return c.substring(nameEQ.length, c.length);
      }
      return null;
    },
    checkCookieConsent() {
      const consent = this.getCookie("cookieConsent");
      this.showCookieBanner = !consent;
    },
  },
  mounted() {
    this.checkCookieConsent();
  },
};
</script>

<style lang="scss" scoped>
.cookies {
  left: 0;
  width: 100%;
  padding-top: 1rem;
  padding-bottom: 1rem;
  background-color: var(--white);
  border-top: 1px solid var(--pink);
  position: fixed;
  bottom: 0;
  z-index: 998;
  .cookies-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    p {
      font-size: 14px;
      color: var(--black);
      a {
        color: var(--black);
        transition: 0.5s;
        text-underline-offset: 4px;
        &:hover {
          color: var(--pink);
        }
      }
    }
    .cookies-button {
      .cookies-btn {
        background-color: var(--pink);
        padding-left: 2rem;
        padding-right: 2rem;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        color: var(--white);
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid var(--pink);
        transition: 0.5s;
        cursor: pointer;
        &:hover {
          color: var(--pink);
          background-color: var(--white);
        }
      }
    }
  }
}

@media screen and (max-width: 1200px) {
  .cookies {
    .cookies-content {
      flex-direction: column;
      justify-content: flex-start;
      align-items: flex-start;
      p {
        margin-bottom: 1rem;
      }
    }
  }
}
</style>
