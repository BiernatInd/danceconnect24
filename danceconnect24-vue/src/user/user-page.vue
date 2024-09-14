<template>
  <UserHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <h1>My account:</h1>
        <p>Nickname: {{ nickname }}</p>
        <p>Email: {{ email }}</p>
      </div>
      <div class="home-right">
        <div class="calendar">
          <div class="calendar-top">
            <div class="calendar-top-left">
              <h2>Class schedule</h2>
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
        </div>
      </div>
    </div>
  </div>
  <MainFooter />
</template>

<script>
import UserHeader from "@user-components/user-header.vue";
import MainFooter from "@main-components/main-footer.vue";
import axios from "axios";

export default {
  components: {
    UserHeader,
    MainFooter,
  },
  data() {
    return {
      currentDate: new Date(),
      month: "",
      year: "",
      daysInCurrentMonth: [],

      isReservationActive: false,
      classesData: [],

      nickname: "",
      email: "",
      classCount: 0, // Domyślnie 0, zaktualizowane po otrzymaniu danych
      clientCount: 0,
    };
  },
  methods: {
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

      try {
        const response = await axios.get(
          "http://localhost:8000/user/events-page",
          {
            params: {
              month: monthString,
            },
          }
        );

        console.log("Response data:", response.data);

        // Ustawianie liczby wydarzeń dla każdego dnia w bieżącym miesiącu
        this.daysInCurrentMonth = this.daysInCurrentMonth.map((day) => {
          if (day.dayOfMonth) {
            const eventForDay = response.data.find(
              (event) =>
                event.date ===
                `${year}-${month}-${String(day.dayOfMonth).padStart(2, "0")}`
            );
            day.eventsCount = eventForDay ? eventForDay.count : 0;
          }
          return day;
        });

        console.log("Updated days in current month:", this.daysInCurrentMonth);
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    },
    async getClasses(day) {
      if (day.dayOfMonth) {
        const year = this.year;
        const month = String(this.currentDate.getMonth() + 1).padStart(2, "0");
        const dayOfMonth = String(day.dayOfMonth).padStart(2, "0");

        console.log("Request parameters:");
        console.log({
          day: dayOfMonth,
          month: month,
          year: year,
        });

        try {
          // Wysyłamy zapytanie POST do kontrolera Laravel
          const response = await axios.post(
            "http://localhost:8000/user/classes-page",
            {
              day: dayOfMonth,
              month: month,
              year: year,
            }
          );

          // Przetwarzanie odpowiedzi
          const classesData = response.data;
          console.log("Classes Data:", classesData);

          this.classesData = classesData; // Dodanie danych klas do stanu
          this.isReservationActive = true; // Otworzenie sekcji rezerwacji

          // Możesz również zrobić coś z danymi, np. zaktualizować stan komponentu
          // this.classes = classesData;
        } catch (error) {
          console.error("Error fetching classes:", error);
        }
      }
    },
    closeReservations() {
      this.isReservationActive = false; // Zamykamy sekcję rezerwacji
    },
    async access() {
      try {
        const token = localStorage.getItem("token");
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        await axios.post("http://localhost:8000/authentication/user-access");
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
  z-index: 999;
  align-items: center;
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
          p:not(:last-child) {
            margin-bottom: 1rem;
          }
          p {
            font-weight: 400;
            font-size: 16px;
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
}
</style>
