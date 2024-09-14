<template>
  <header :class="['header', { active: isHeaderActive }]">
    <nav class="nav">
      <div class="nav-logo">
        <img src="@assets/logo.svg" alt="" />
      </div>
      <div class="nav-menu">
        <svg
          @click="toggleMenu"
          width="22"
          height="39"
          viewBox="0 0 22 39"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M20 37L3 19.5L20 2" stroke-width="4" />
        </svg>
      </div>
    </nav>
  </header>

  <div :class="['menu', { active: isMenuActive }]">
    <div class="menu-content">
      <div class="menu-top">
        <img src="@assets/logo.svg" alt="" />
        <svg
          @click="toggleMenu"
          width="22"
          height="39"
          viewBox="0 0 22 39"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M20 37L3 19.5L20 2" stroke-width="4" />
        </svg>
      </div>
      <div class="menu-bottom">
        <!-- Main Menu: Zajęcia -->
        <div class="menu-link" @click="redirectToAdminPage">
          <p href="#">Admin Page</p>
        </div>
        <div
          class="menu-link"
          @click="toggleActive(0)"
          :class="{ active: activeIndex === 0 }"
        >
          <p href="#">Users</p>
          <svg
            :class="{ active: activeIndex === 0 }"
            width="22"
            height="12"
            viewBox="0 0 22 12"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M1 1L11 11L21 1" />
          </svg>
        </div>
        <div
          class="menu-link-child"
          v-if="activeIndex === 0"
          @click="redirectToUsersList"
        >
          <p href="#">Users list</p>
        </div>
        <!-- Main Menu: Klienci -->
        <div
          class="menu-link"
          @click="toggleActive(1)"
          :class="{ active: activeIndex === 1 }"
        >
          <p href="#">Schools</p>
          <svg
            :class="{ active: activeIndex === 1 }"
            width="22"
            height="12"
            viewBox="0 0 22 12"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M1 1L11 11L21 1" />
          </svg>
        </div>
        <div
          class="menu-link-child"
          v-if="activeIndex === 1"
          @click="redirectToSchoolList"
        >
          <p href="#">Schools list</p>
        </div>

        <div
          class="menu-link"
          @click="toggleActive(2)"
          :class="{ active: activeIndex === 2 }"
        >
          <p href="#">Classes</p>
          <svg
            :class="{ active: activeIndex === 2 }"
            width="22"
            height="12"
            viewBox="0 0 22 12"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M1 1L11 11L21 1" />
          </svg>
        </div>
        <div
          class="menu-link-child"
          v-if="activeIndex === 2"
          @click="redirectToUsersClients"
        >
          <p href="#">Users classes</p>
        </div>

        <!-- Main Menu: Ustawienia konta -->
        <div class="menu-link" @click="redirectToSettings">
          <p href="#">Account settings</p>
        </div>

        <!-- Main Menu: Wyloguj się -->
        <div class="menu-link" @click="logout">
          <p href="#">Logout</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      isMenuActive: false, // Ustawienia początkowe stanu menu
      isHeaderActive: false, // Ustawienie klasy active dla header
      activeIndex: null, // Bieżący aktywny indeks dla menu-link i menu-link-child
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuActive = !this.isMenuActive; // Zmieniaj stan menu
    },
    toggleActive(index) {
      // Ustawia aktywny indeks dla menu-link
      if (this.activeIndex === index) {
        this.activeIndex = null; // Jeżeli kliknięty ponownie, deaktywuj
      } else {
        this.activeIndex = index;
      }
    },
    handleScroll() {
      if (window.scrollY > 0) {
        this.isHeaderActive = true; // Dodaj klasę active jeśli scroll > 0
      } else {
        this.isHeaderActive = false; // Usuń klasę active jeśli scroll = 0
      }
    },
    redirectToUsersList() {
      this.$router.push("/admin-users-list");
    },
    redirectToSchoolList() {
      this.$router.push("/admin-school-list");
    },
    redirectToAdminPage() {
      this.$router.push("/admin-page");
    },
    redirectToUsersClients() {
      this.$router.push("/admin-school-clients");
    },
    redirectToSettings() {
      this.$router.push("/admin-settings");
    },
    async logout() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        await axios.post("http://localhost:8000/authentication/logout"); // Endpoint do wylogowania

        localStorage.clear(); // Wyczyść localStorage
        this.$router.push("/"); // Przekieruj na stronę główną
      } catch (error) {
        console.error("Error logging out:", error);
        // Możesz dodać odpowiednie powiadomienie dla użytkownika
      }
    },
  },
  mounted() {
    window.addEventListener("scroll", this.handleScroll); // Nasłuchuj scrolla
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll); // Usuń nasłuchiwanie podczas usuwania komponentu
  },
};
</script>

<style lang="scss" scoped>
.header {
  position: fixed;
  width: 100%;
  max-width: 1920px;
  top: 0;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  transition: background-color 0.3s ease-in-out;
  z-index: 99;
  .nav {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    .nav-menu {
      svg {
        cursor: pointer;
        path {
          stroke: var(--purple);
        }
      }
    }
  }
  &.active {
    background-color: var(--white);
    .nav {
      .nav-menu {
        svg {
          path {
            stroke: var(--purple);
          }
        }
      }
    }
  }
}

.menu {
  position: fixed;
  width: 25%;
  height: 100%;
  right: -100%;
  top: 0px;
  z-index: 99;
  background-color: var(--white);
  border-left: 1px solid var(--purple);
  transition: right 0.3s ease-in-out;
  &.active {
    right: 0;
  }
  .menu-content {
    width: 90%;
    margin-left: auto;
    margin-right: auto;
    .menu-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1rem;
      svg {
        transform: rotate(180deg);
        cursor: pointer;
        path {
          stroke: var(--purple);
        }
      }
    }
    .menu-bottom {
      margin-top: 1rem;
      .menu-link {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--purple);
        transition: 0.5s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        p {
          font-size: 16px;
          color: var(--black);
        }
        svg {
          transition: 0.5s;
          path {
            stroke: var(--purple);
          }
        }
        &:hover {
          transform: translateY(-5px);
          border-bottom: 1px solid var(--pink);
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
      .menu-link.active {
        svg {
          transform: rotate(180deg);
          path {
            stroke: var(--pink);
          }
        }
        p {
          color: var(--pink);
        }
      }
      .menu-link-child {
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--purple);
        transition: 0.5s;
        cursor: pointer;
        p {
          font-size: 16px;
          color: var(--black);
        }
        &:hover {
          transform: translateY(-5px);
          border-bottom: 1px solid var(--pink);
          p {
            color: var(--pink);
          }
        }
      }
    }
  }
}

@media screen and (max-width: 1200px) {
  .header {
    .nav {
      width: 90%;
      .nav-menu {
        svg {
          path {
            stroke: var(--purple);
          }
        }
      }
    }
  }
  .menu {
    width: 100%;
    .menu-content {
      .menu-bottom {
        overflow: auto;
      }
    }
  }
}
</style>
