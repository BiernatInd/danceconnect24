<template>
  <AdminHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h1>My account:</h1>
        <p>Nickname: {{ userNickname }}</p>
        <p>E-mail: {{ userEmail }}</p>
        <p>All classes: {{ totalClasses }}</p>
        <p>All clients: {{ totalClients }}</p>
      </div>
      <div class="home-right">
        <table>
          <thead>
            <tr>
              <th>Id</th>
              <th>Class Name</th>
              <th>Markings</th>
              <th>Class Type</th>
              <th>Places</th>
              <th>Room</th>
              <th>Instructor</th>
              <th>Date</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Price</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="classItem in classes" :key="classItem.id">
              <td data-label="Id">{{ classItem.id }}</td>
              <td data-label="Class Name">{{ classItem.class_name }}</td>
              <td data-label="Markings">{{ classItem.markings }}</td>
              <td data-label="Class Type">{{ classItem.class_type }}</td>
              <td data-label="Places">{{ classItem.places }}</td>
              <td data-label="Room">{{ classItem.room }}</td>
              <td data-label="Instructor">{{ classItem.instructor }}</td>
              <td data-label="Date">{{ formatDate(classItem.date) }}</td>
              <td data-label="Start Time">{{ classItem.time_start }}</td>
              <td data-label="End Time">{{ classItem.time_end }}</td>
              <td data-label="Price">{{ classItem.price }}</td>
              <td data-label="Details">
                <svg
                  width="21"
                  height="22"
                  viewBox="0 0 21 22"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                  @click="showConfirmation(classItem)"
                >
                  <path
                    d="M8.14233 15.2188L8.14233 11.6972"
                    stroke-linecap="round"
                  />
                  <path
                    d="M13.7118 15.2188L13.7118 11.6972"
                    stroke-linecap="round"
                  />
                  <path
                    d="M0.901855 5.82812H20.9522V5.82812C19.165 5.82812 18.2714 5.82812 17.6967 6.35878C17.6577 6.39477 17.6202 6.4323 17.5842 6.47128C17.0535 7.04594 17.0535 7.93956 17.0535 9.72681V17.0883C17.0535 18.9739 17.0535 19.9168 16.4678 20.5025C15.882 21.0883 14.9392 21.0883 13.0535 21.0883H8.80054C6.91492 21.0883 5.97211 21.0883 5.38633 20.5025C4.80054 19.9168 4.80054 18.9739 4.80054 17.0883V9.72681C4.80054 7.93956 4.80054 7.04594 4.26989 6.47128C4.23389 6.4323 4.19636 6.39477 4.15738 6.35878C3.58273 5.82812 2.6891 5.82812 0.901855 5.82812V5.82812Z"
                    stroke-linecap="round"
                  />
                  <path
                    d="M8.14224 2.30696C8.14224 2.30696 8.6992 1.13281 10.927 1.13281C13.1548 1.13281 13.7118 2.30667 13.7118 2.30667"
                    stroke-linecap="round"
                  />
                </svg>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="confirmation" :class="{ active: isConfirmationActive }">
    <div class="confirmation-content">
      <h2>Deleting class</h2>
      <p>
        Are you sure you want to delete the class "{{
          selectedClass ? selectedClass.class_name : ""
        }}"?
      </p>
      <div class="confirmation-button">
        <button class="confirmation-btn" @click="hideConfirmation">
          Cancel
        </button>
        <button class="confirmation-btn" @click="confirmDelete">
          Delete class
        </button>
      </div>
    </div>
  </div>
  <MainFooter />
</template>

<script>
import AdminHeader from "@admin-components/admin-header.vue";
import MainFooter from "@main-components/main-footer.vue";
import axios from "axios";

export default {
  components: {
    AdminHeader,
    MainFooter,
  },
  data() {
    return {
      isConfirmationActive: false,
      classes: [], // Lista zajęć
      selectedClass: null, // Przechowywanie wybranego do usunięcia zajęcia\
      userNickname: "",
      userEmail: "",
      totalClients: 0,
      totalClasses: 0,
    };
  },
  methods: {
    async fetchCounts() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const [clientsResponse, classesResponse] = await Promise.all([
          axios.get("http://localhost:8000/admin/count-clients"),
          axios.get("http://localhost:8000/admin/count-classes"),
        ]);

        this.totalClients = clientsResponse.data.count;
        this.totalClasses = classesResponse.data.count;
      } catch (error) {
        console.error("Failed to fetch counts:", error);
      }
    },
    async fetchUserDetails() {
      this.userNickname = localStorage.getItem("nickname") || "";
      this.userEmail = localStorage.getItem("email") || "";
    },
    showConfirmation(classItem) {
      this.selectedClass = classItem;
      this.isConfirmationActive = true;
    },
    hideConfirmation() {
      this.isConfirmationActive = false;
    },
    async fetchClasses() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        const response = await axios.get(
          "http://localhost:8000/admin/classes-list"
        ); // Endpoint do pobierania zajęć
        this.classes = response.data;
      } catch (error) {
        console.error("Error fetching classes:", error);
      }
    },
    formatDate(date) {
      const options = { year: "numeric", month: "2-digit", day: "2-digit" };
      return new Date(date).toLocaleDateString(undefined, options);
    },
    async confirmDelete() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        if (this.selectedClass && this.selectedClass.id) {
          await axios.post("http://localhost:8000/admin/classes-delete", {
            id: this.selectedClass.id,
          });
          // Usunięcie klasy z lokalnej listy
          this.classes = this.classes.filter(
            (classItem) => classItem.id !== this.selectedClass.id
          );
          this.hideConfirmation(); // Zamknięcie modalu
        }
      } catch (error) {
        console.error("Error deleting class:", error);
      }
    },
    async access() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        await axios.post("http://localhost:8000/authentication/admin-access");
      } catch (error) {
        this.$router.push("/login");
      }
    },
  },
  mounted() {
    this.access();
    this.fetchClasses(); // Pobranie danych o zajęciach po zamontowaniu komponentu
    this.fetchCounts();
    this.fetchUserDetails();
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
    flex-direction: column;
    padding-top: 100px;
    .home-left {
      width: 100%;
      padding: 1rem;
      box-shadow: var(--box-shadow);
      border-radius: 15px;
      height: 100%;
      margin-bottom: 2rem;
      h1 {
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
      width: 100%;
      table {
        width: 100%;
        border-radius: 15px;
        border-collapse: separate;
        border-spacing: 0;
        background-color: var(--white);
        box-shadow: var(--box-shadow);
        th {
          padding: 12px;
          text-align: center;
          font-size: 16px;
          font-weight: 400;
        }
        td:nth-child(5) {
          display: flex;
          align-items: center;
          justify-content: center;
        }
        td {
          padding: 12px;
          text-align: center;
          font-weight: 400;
          white-space: normal;
          font-size: 16px;
          border-top: 1px solid var(--pink);
          font-weight: 400;
          svg {
            width: 20px;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            cursor: pointer;
            stroke: var(--black);
            transition: 0.5s;
            &:hover {
              stroke: var(--pink);
            }
          }
          svg:nth-child(2) {
            position: relative;
            bottom: 5px;
          }
          a {
            color: var(--black);
            text-underline-offset: 4px;
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
        table,
        thead,
        tbody,
        th,
        td,
        tr {
          display: block;
          border: none;
        }
        table {
          thead {
            tr {
              position: absolute;
              top: -9999px;
              left: -9999px;
            }
          }
          tbody {
            tr {
              border-radius: 10px;
              td {
                border-top: none;
                position: relative;
                padding-left: 50%;
                font-size: 12px;
                text-align: right;
                img {
                  width: 16px;
                }
                svg:nth-child(2) {
                  position: relative;
                  bottom: 0px;
                }
              }
              td {
                position: relative;
                padding-left: 50%;
                font-size: 12px;
                text-align: right;
                img {
                  width: 16px;
                }
              }
              td:not(:last-child) {
                border-bottom: 1px solid var(--pink);
              }
              td:last-child {
                display: flex;
                align-items: center;
                justify-content: flex-end;
              }
              tr {
                border: 2px solid var(--pink);
                border-radius: 10px;
              }
              td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: 400;
                text-align: left;
              }
            }
          }
        }
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
