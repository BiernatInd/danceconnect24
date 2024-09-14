<template>
  <SchoolHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h1>My account:</h1>
        <p>Nickname: {{ nickname }}</p>
        <p>Email: {{ email }}</p>
        <p>My classes: {{ classCount }}</p>
        <p>My clients: {{ clientCount }}</p>
      </div>
      <div class="home-right">
        <div class="calendar">
          <div class="calendar-top">
            <div class="calendar-top-left">
              <h2>My clients</h2>
            </div>
            <div class="calendar-top-right">
              <img
                src="@icons/calendar-arrow-left.svg"
                alt="Previous Month"
                @click="goToPreviousMonth"
              />
              <p>{{ month }} {{ year }}</p>
              <img
                src="@icons/calendar-arrow-right.svg"
                alt="Next Month"
                @click="goToNextMonth"
              />
            </div>
          </div>

          <div class="calendar-bottom">
            <div
              v-for="(week, weekIndex) in calendarWeeks"
              :key="weekIndex"
              class="calendar-item-box"
            >
              <div
                v-for="(day, dayIndex) in week"
                :key="dayIndex"
                :class="[
                  'calendar-item',
                  { 'calendar-item-empty': !day.dayOfMonth },
                ]"
              >
                <div class="calendar-item-top">
                  <p>{{ day.dayOfWeek }}</p>
                  <p>{{ day.dayOfMonth }}</p>
                </div>
                <div class="calendar-item-bottom">
                  <h2>{{ day.eventsCount }} Events</h2>
                  <div class="calendar-item-button">
                    <button
                      class="calendar-item-btn"
                      @click="getClasses(day)"
                      :disabled="!day.dayOfMonth"
                    >
                      See more
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div :class="['reservation', { active: isReservationActive }]">
    <div class="reservation-content">
      <div class="reservation-top">
        <h2>Classes:</h2>

        <img src="@icons/close.svg" alt="" @click="closeReservations" />
      </div>
      <div
        v-for="(box, boxIndex) in groupedClasses"
        :key="boxIndex"
        class="reservation-box"
      >
        <div
          v-for="(reservation, index) in box"
          :key="reservation.id"
          class="reservation-item"
        >
          <div class="reservation-item-top">
            <p>{{ reservation.instructor }}</p>
            <p>
              {{ formatTime(reservation.time_start) }} -
              {{ formatTime(reservation.time_end) }}
            </p>
          </div>
          <div class="reservation-item-mid">
            <p>Class name: {{ reservation.class_name }}</p>
            <p>Markings: {{ reservation.markings }}</p>
            <p>Class type: {{ reservation.class_type }}</p>
            <p>Places: {{ reservation.places }}</p>
            <p>Room number: {{ reservation.room }}</p>
            <p>Price: {{ reservation.price }} AED</p>
          </div>
          <div class="reservation-item-button">
            <button
              class="reservation-item-btn"
              @click="showClients(reservation.id)"
            >
              Show Clients
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div :class="['clients', { active: isClientsActive }]">
    <div class="clients-content">
      <div class="clients-top">
        <h2>Clients</h2>
        <img src="@icons/close.svg" alt="" @click="closeClients" />
      </div>
      <div
        v-for="(box, boxIndex) in groupedClients"
        :key="boxIndex"
        class="clients-box"
      >
        <div
          v-for="(client, index) in box"
          :key="client.id"
          class="clients-item"
        >
          <div class="clients-item-mid">
            <p>Name: {{ client.name }}</p>
            <p>Surname: {{ client.surname }}</p>
            <p>E-mail: {{ client.email }}</p>
            <p>Phone number: {{ client.phone_number }}</p>
            <p>Sex: {{ client.sex }}</p>
            <p>Sign Up Type: {{ client.sign_up_type }}</p>
            <p>Price: {{ client.price }} AED</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <MainFooter />
</template>

<script>
import SchoolHeader from "@school-components/school-header.vue";
import MainFooter from "@main-components/main-footer.vue";
import axios from "axios";

export default {
  components: {
    SchoolHeader,
    MainFooter,
  },
  data() {
    return {
      currentDate: new Date(),
      month: "",
      year: "",
      daysInCurrentMonth: [],

      selectedCourseType: "",
      selectedInstructor: "",
      selectedClassType: "",

      isReservationActive: false,
      classesData: [],

      isClientsActive: false,

      clientsData: [],

      selectedClassId: null,

      nickname: "",
      email: "",
      classCount: 0, // Domyślnie 0, zaktualizowane po otrzymaniu danych
      clientCount: 0,
    };
  },
  methods: {
    async fetchClassCount() {
      try {
        // Wysyłanie żądania GET do kontrolera Laravel z podanym pseudonimem
        const response = await axios.get(
          "http://localhost:8000/school/classes-count",
          {
            params: {
              nickname: this.nickname, // Pseudonim z komponentu Vue
            },
          }
        );

        const classCount = response.data.class_count;
        console.log(`Liczba klas dla instruktora: ${classCount}`);

        // Możesz zaktualizować dane komponentu lub wyświetlić je
        this.classCount = classCount;
      } catch (error) {
        console.error("Error fetching class count:", error);
      }
    },
    async fetchClientCount() {
      try {
        // Wysyłanie żądania GET do kontrolera Laravel z podanym pseudonimem
        const response = await axios.get(
          "http://localhost:8000/school/clients-count",
          {
            params: {
              nickname: this.nickname, // Pseudonim z komponentu Vue
            },
          }
        );

        const clientCount = response.data.client_count;
        console.log(`Liczba klientów dla instruktora: ${clientCount}`);

        // Możesz zaktualizować dane komponentu lub wyświetlić je
        this.clientCount = clientCount;
      } catch (error) {
        console.error("Error fetching client count:", error);
      }
    },
    async showClients(classId) {
      this.isReservationActive = false;
      this.isClientsActive = true;

      // Pobranie nickname z localStorage
      const nickname = localStorage.getItem("nickname");

      if (nickname && classId) {
        await this.getClients(nickname, classId); // Przekazanie classId do getClients
      } else {
        console.error("Nickname not found in localStorage or classId not set");
      }
    },

    showReservations() {
      this.isClientsActive = false;
      this.isReservationActive = true;
    },

    closeReservations() {
      this.isClientsActive = false;
      this.isReservationActive = false;
    },

    closeClients() {
      this.isClientsActive = false;
      this.isReservationActive = true;
    },

    formatTime(time) {
      const [hours, minutes] = time.split(":").map(Number);
      const ampm = hours >= 12 ? "PM" : "AM";
      const formattedHours = hours % 12 || 12; // Przekonwertowanie na 12-godzinny format
      const formattedMinutes = minutes.toString().padStart(2, "0");
      return `${formattedHours}:${formattedMinutes} ${ampm}`;
    },
    getDateInfo() {
      const currentDate = this.currentDate;

      // Miesiąc i rok
      const month = currentDate.getMonth();
      const year = currentDate.getFullYear();

      // Długość miesiąca
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      // Tablica nazw dni tygodnia
      const daysOfWeekNames = [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
      ];

      // Nazwa miesiąca
      const monthName = new Intl.DateTimeFormat("en", {
        month: "long",
      }).format(currentDate);

      // Ustalanie dnia tygodnia dla 1. dnia miesiąca
      const firstDayOfMonth = new Date(year, month, 1).getDay();
      // Przesunięcie, aby pierwszy dzień miesiąca był poniedziałkiem
      const offset = (firstDayOfMonth + 6) % 7;

      // Generowanie pustych dni przed dniami miesiąca
      let daysArray = [];
      for (let i = 0; i < offset; i++) {
        daysArray.push({
          dayOfWeek: daysOfWeekNames[(6 - offset + i + 1) % 7], // Poprawne dni tygodnia przed początkiem miesiąca
          dayOfMonth: "",
          eventsCount: 0,
        });
      }

      // Generowanie dni miesiąca
      for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const dayOfWeek =
          daysOfWeekNames[date.getDay() === 0 ? 6 : date.getDay() - 1]; // Zmieniamy Sunday na 6 (Saturday)
        daysArray.push({
          dayOfWeek,
          dayOfMonth: day,
          eventsCount: Math.floor(Math.random() * 5) + 1, // losowa liczba wydarzeń
        });
      }

      // Ustawianie danych
      this.month = monthName;
      this.year = year;
      this.daysInCurrentMonth = daysArray; // Ustawienie wartości daysInCurrentMonth
    },
    goToPreviousMonth() {
      this.currentDate.setMonth(this.currentDate.getMonth() - 1);
      this.getDateInfo();
      this.getEvents(); // Wywołanie getEvents, aby pobrać dane po zmianie miesiąca
    },
    goToNextMonth() {
      this.currentDate.setMonth(this.currentDate.getMonth() + 1);
      this.getDateInfo();
      this.getEvents(); // Wywołanie getEvents, aby pobrać dane po zmianie miesiąca
    },
    async getEvents() {
      const year = this.currentDate.getFullYear();
      const month = String(this.currentDate.getMonth() + 1).padStart(2, "0");
      const monthString = `${year}-${month}`;

      // Pobranie nickname z localStorage
      const nickname = localStorage.getItem("nickname");

      console.log("Request parameters:");
      console.log({
        month: monthString,
        nickname: nickname, // Dodanie nickname do parametrów zapytania
      });

      try {
        const response = await axios.get(
          "http://localhost:8000/school/events",
          {
            params: {
              month: monthString,
              nickname: nickname, // Dodanie nickname do parametrów zapytania
            },
          }
        );

        console.log("Response data:");
        console.log(response.data);

        const eventsData = response.data;

        this.daysInCurrentMonth = this.daysInCurrentMonth.map((day) => {
          if (day.dayOfMonth) {
            const eventForDay = eventsData.find(
              (event) =>
                event.date ===
                `${year}-${month}-${String(day.dayOfMonth).padStart(2, "0")}`
            );
            day.eventsCount = eventForDay ? eventForDay.count : 0;
          }
          return day;
        });

        console.log("Updated days in current month:");
        console.log(this.daysInCurrentMonth);
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    },
    async getClasses(day) {
      if (day.dayOfMonth) {
        const year = this.year;
        const month = String(this.currentDate.getMonth() + 1).padStart(2, "0");
        const dayOfMonth = String(day.dayOfMonth).padStart(2, "0");

        const nickname = localStorage.getItem("nickname");

        if (!nickname) {
          console.error("Nickname not found in localStorage");
          return;
        }

        try {
          const response = await axios.post(
            "http://localhost:8000/school/classes",
            {
              nickname: nickname,
              day: dayOfMonth,
              month: month,
              year: year,
            }
          );

          const classesData = response.data;
          this.classesData = classesData;
          this.isReservationActive = true;

          // Set the selectedClassId to null or appropriate value here if needed
        } catch (error) {
          console.error("Error fetching classes:", error);
        }
      }
    },

    async getClients(nickname, classId) {
      try {
        const response = await axios.post(
          "http://localhost:8000/school/clients",
          { nickname: nickname, classId: classId } // Dodaj classId do danych zapytania
        );

        const clientsData = response.data;
        console.log("Clients Data:", clientsData);

        this.clientsData = clientsData; // Zaktualizuj stan klientów
        this.isClientsActive = true; // Otwórz sekcję klientów
      } catch (error) {
        console.error("Error fetching clients:", error);
      }
    },

    async access() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        await axios.post("http://localhost:8000/authentication/school-access");
      } catch (error) {
        this.$router.push("/login");
      }
    },
  },
  computed: {
    groupedClasses() {
      const grouped = [];
      let currentGroup = [];

      this.classesData.forEach((reservation, index) => {
        currentGroup.push(reservation);

        if (
          currentGroup.length === 3 ||
          index === this.classesData.length - 1
        ) {
          grouped.push(currentGroup);
          currentGroup = [];
        }
      });

      return grouped;
    },

    groupedClients() {
      const grouped = [];
      let currentGroup = [];

      this.clientsData.forEach((client, index) => {
        currentGroup.push(client);

        if (
          currentGroup.length === 3 ||
          index === this.clientsData.length - 1
        ) {
          grouped.push(currentGroup);
          currentGroup = [];
        }
      });

      return grouped;
    },

    calendarWeeks() {
      // Tablica podzielona na tygodnie (maksymalnie 7 dni w każdym tygodniu)
      const weeks = [];
      const days = [...this.daysInCurrentMonth]; // Kopiujemy tablicę dni

      // Dodanie pustych dni na końcu, aby ostatni tydzień miał pełne 7 dni
      while (days.length % 7 !== 0) {
        days.push({
          dayOfWeek: "",
          dayOfMonth: "",
          eventsCount: 0,
        });
      }

      // Pętla dzieli tablicę dni na podtablice o maksymalnej długości 7 (tygodnie)
      while (days.length > 0) {
        weeks.push(days.splice(0, 7)); // Z każdej iteracji pobiera pierwsze 7 dni i tworzy nową grupę
      }

      return weeks; // Zwracamy tablicę tygodni
    },
  },
  mounted() {
    this.getDateInfo();
    this.getEvents();
    this.access();
    this.nickname = localStorage.getItem("nickname") || "Unknown";
    this.email = localStorage.getItem("email") || "No email available";
    this.fetchClassCount();
    this.fetchClientCount();
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
    padding-top: 100px;
    .home-left {
      width: calc(30% - 1rem);
      padding: 1rem;
      box-shadow: var(--box-shadow);
      border-radius: 15px;
      height: 100%;
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
      width: calc(70% - 1rem);
      .calendar {
        height: 800px;
        overflow-y: scroll;

        padding: 1rem;
        border-radius: 15px;
        box-shadow: var(--box-shadow);
        background-color: var(--white);

        .calendar-top {
          margin-bottom: 1rem;
          display: flex;
          justify-content: space-between;

          .calendar-top-left {
            width: 50%;

            h2 {
              font-size: 24px;
              color: var(--black);
              font-weight: 600;
            }
          }

          .calendar-top-right {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: flex-end;

            img:first-child {
              margin-right: 1rem;
            }

            img:last-child {
              margin-left: 1rem;
            }
          }
        }

        .calendar-bottom {
          height: calc(
            100% - 50px
          ); /* Dostosowujemy wysokość do dostępnej przestrzeni */
          padding-right: 1rem;
          padding-left: 1rem;
          padding-top: 1rem;
          .calendar-item-box:not(:last-child) {
            margin-bottom: 1rem;
          }
          .calendar-item-box {
            display: flex;
          }
          .calendar-item:not(:last-child) {
            margin-right: 2rem;
          }
          .calendar-item {
            box-shadow: var(--box-shadow);
            border-radius: 10px;
            width: 169.6px;
            height: 169.6px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: white; /* Usuwamy czerwone tło */

            .calendar-item-top {
              display: flex;
              justify-content: space-between;
              padding: 1rem;

              p {
                font-size: 16px;
                font-weight: 400;
                color: var(--black);
              }
            }

            .calendar-item-bottom {
              h2 {
                font-size: 20px;
                padding: 1rem;
              }

              .calendar-item-button {
                .calendar-item-btn {
                  width: 100%;
                  height: 40px;
                  background-color: var(--purple);
                  border: 1px solid var(--purple);
                  border-radius: 5px;
                  color: var(--white);
                  font-size: 16px;
                  cursor: pointer;
                  transition: 0.5s;

                  &:hover {
                    background-color: var(--pink);
                    color: var(--white);
                    border: 1px solid var(--pink);
                  }
                }
              }
            }
          }
          .calendar-item-empty {
            opacity: 0;
            pointer-events: none; /* Blokuje wszelkie interakcje z elementem */
          }
        }
      }
    }
  }
}

.reservation {
  position: fixed;
  width: 100%;
  height: 100%;
  max-width: 1920px;
  top: -100%;
  display: flex;
  align-items: center;
  z-index: 999;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.2);
  transition: 0.5s;
  &.active {
    top: 0;
  }
  .reservation-content {
    width: 80%;
    height: 560px;
    overflow-y: scroll;
    background-color: var(--white);
    border-radius: 15px;
    padding: 2rem;
    .reservation-top {
      display: flex;
      justify-content: space-between;
      margin-bottom: 2rem;
      h2 {
        font-size: 24px;
        color: var(--black);
        font-weight: 600;
      }
    }
    .reservation-box:not(:last-child) {
      margin-bottom: 2rem;
    }
    .reservation-box {
      display: flex;
      justify-content: space-between;

      .reservation-item {
        width: 30%;
        background-color: var(--white);
        box-shadow: var(--box-shadow);
        padding: 1rem;
        border-radius: 15px;
        .reservation-item-top {
          display: flex;
          justify-content: space-between;
          margin-bottom: 1rem;
          p {
            font-size: 16px;
            color: var(--black);
            font-weight: 400;
          }
        }
        .reservation-item-mid {
          p {
            font-weight: 400;
            font-size: 16px;
            margin-bottom: 1rem;
          }
        }
        .reservation-item-button {
          .reservation-item-btn {
            background-color: var(--purple);
            height: 40px;
            width: 100%;
            border: 1px solid var(--purple);
            border-radius: 5px;
            color: var(--white);
            font-size: 16px;
            cursor: pointer;
            transition: 0.5s;
          }
        }
      }
    }
  }
}

.clients {
  position: fixed;
  width: 100%;
  height: 100%;
  max-width: 1920px;
  top: -100%;
  display: flex;
  align-items: center;
  z-index: 999;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.2);
  transition: 0.5s;
  &.active {
    top: 0;
  }
  .clients-content {
    width: 80%;
    height: 560px;
    overflow-y: scroll;
    background-color: var(--white);
    border-radius: 15px;
    padding: 2rem;
    .clients-top {
      display: flex;
      justify-content: space-between;
      margin-bottom: 2rem;
      h2 {
        font-size: 24px;
        color: var(--black);
        font-weight: 600;
      }
    }
    .clients-box:not(:last-child) {
      margin-bottom: 2rem;
    }
    .clients-box {
      display: flex;
      justify-content: space-between;

      .clients-item {
        width: 30%;
        background-color: var(--white);
        box-shadow: var(--box-shadow);
        padding: 1rem;
        border-radius: 15px;
        .clients-item-mid {
          p:not(:last-child) {
            margin-bottom: 1rem;
          }
          p {
            font-weight: 400;
            font-size: 16px;
          }
        }
      }
    }
  }
}

@media screen and (max-width: 1500px) {
  .home {
    .home-content {
      .home-right {
        .calendar {
          overflow-y: none;
          .calendar-bottom {
            padding-right: 0;
            padding-left: 0;
            padding-top: 1rem;
            overflow-y: scroll;
            .calendar-item-box {
              width: 1300px;
              .calendar-item {
                width: 160px;
                height: 160px;
                .calendar-item-top {
                  p {
                    font-size: 14px;
                  }
                }
                .calendar-item-bottom {
                  h2 {
                    font-size: 14px;
                  }
                  .calendar-item-button {
                    .calendar-item-btn {
                      height: 40px;
                      font-size: 14px;
                    }
                  }
                }
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
    .home-content {
      flex-direction: column;
      .home-left {
        width: 100%;
        margin-bottom: 2rem;
      }
      .home-right {
        width: 100%;
      }
    }
  }
  .reservation {
    .reservation-content {
      width: 100%;
      height: 100%;
      border-radius: 0;
      padding: 2rem;
      .reservation-top {
        margin-bottom: 2rem;
        h2 {
          font-size: 20px;
        }
      }
      .reservation-box:not(:last-child) {
        margin-bottom: 2rem;
      }
      .reservation-box {
        flex-direction: column;
        .reservation-item:not(:last-child) {
          margin-bottom: 2rem;
        }
        .reservation-item {
          width: 100%;
        }
      }
    }
  }
  .clients {
    .clients-content {
      width: 100%;
      height: 100%;
      border-radius: 0;
      padding: 2rem;
      .clients-top {
        margin-bottom: 2rem;
        h2 {
          font-size: 20px;
        }
      }
      .clients-box:not(:last-child) {
        margin-bottom: 2rem;
      }
      .clients-box {
        flex-direction: column;
        .clients-item:not(:last-child) {
          margin-bottom: 2rem;
        }
        .clients-item {
          width: 100%;
        }
      }
    }
  }
}
</style>
