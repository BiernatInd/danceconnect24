<template>
  <div class="plugin">
    <div class="plugin-content">
      <div class="plugin-left">
        <div class="filter">
          <h2>Filters</h2>
          <div class="filter-item">
            <select v-model="selectedCourseType">
              <option value="">Course type</option>
              <option
                v-for="course in courseTypes"
                :key="course.id"
                :value="course.id"
              >
                {{ course.name }}
              </option>
            </select>
          </div>
          <div class="filter-item">
            <select v-model="selectedInstructor">
              <option value="">Instructor</option>
              <option
                v-for="instructor in instructors"
                :key="instructor.id"
                :value="instructor.id"
              >
                {{ instructor.name }}
              </option>
            </select>
          </div>
          <div class="filter-item">
            <select v-model="selectedClassType">
              <option value="">Class type</option>
              <option
                v-for="classType in classTypes"
                :key="classType.id"
                :value="classType.id"
              >
                {{ classType.name }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="plugin-right">
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

    <div class="markings">
      <div class="markings-content">
        <div class="markings-box">
          <div class="markings-text">
            <h2>Markings</h2>
          </div>
          <div class="markings-box-item">
            <div class="markings-item">
              <p>
                <span> L0- Beginner/Introductory Level: </span>This level is
                designed for those who are new to the dance style or have
                minimal experience. The focus is on foundational techniques,
                basic movements, and understanding the fundamental concepts of
                the dance.
              </p>
            </div>
            <div class="markings-item">
              <p>
                <span> L1- Intermediate Level From 1 to 6 months:</span>
                Intermediate classes build upon the basics and introduce more
                complex movements, combinations, and choreography. Dancers at
                this level usually have a solid understanding of the dance style
                and are ready for more challenging material.
              </p>
            </div>
            <div class="markings-item">
              <p>
                <span> L-2 Advanced Level:</span> Advanced classes are intended
                for experienced dancers who have mastered the fundamentals and
                intermediate techniques. These classes often involve intricate
                choreography, advanced variations, and a higher level of skill
                and artistry.
              </p>
            </div>
            <div class="markings-item">
              <p>
                <span> L3 - Open Level: </span>Some studios offer open-level
                classes, which cater to a broader range of skill levels. These
                classes may have modifications to accommodate both beginners and
                more experienced dancers.
              </p>
            </div>
            <div class="markings-item">
              <p>
                <span> LP Professional/Company Level:</span> Some dance studios
                or schools have classes specifically for professionals or those
                aspiring to pursue a dance career. These classes focus on
                refining techniques, honing performance skills, and preparing
                for professional opportunities.
              </p>
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
              @click="signUpForClass(reservation)"
            >
              Sign up for classes
            </button>
          </div>
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
      currentDate: new Date(),
      month: "",
      year: "",
      daysInCurrentMonth: [],

      classTypes: [],
      courseTypes: [],
      instructors: [],
      selectedCourseType: "",
      selectedInstructor: "",
      selectedClassType: "",

      isReservationActive: false,
      classesData: [],
    };
  },
  methods: {
    signUpForClass(reservation) {
      // Parsowanie daty z rezerwacji (w formacie YYYY-MM-DD)
      const reservationDate = new Date(reservation.date);

      // Sprawdzamy, czy data jest poprawna
      if (isNaN(reservationDate)) {
        console.error("Invalid date in reservation:", reservation.date);
        return;
      }

      // Pobieramy dzień miesiąca
      const dayOfMonth = reservationDate.getDate();

      // Formatowanie czasu na zapisanie go jako przedział godzinowy (np. 8:00 - 16:00)
      const timeRange = `${this.formatTime(
        reservation.time_start
      )} - ${this.formatTime(reservation.time_end)}`;

      // Ustawienie daty wydarzenia na podstawie wybranego dnia z kalendarza
      const eventDate = `${String(reservationDate.getDate()).padStart(
        2,
        "0"
      )}.${String(reservationDate.getMonth() + 1).padStart(
        2,
        "0"
      )}.${reservationDate.getFullYear()}`;

      // Zapis do localStorage: ID zajęć, nazwę zajęć, numer sali, przedział czasowy, datę wydarzenia
      localStorage.setItem("classesId", reservation.id);
      localStorage.setItem("className", reservation.class_name);
      localStorage.setItem("roomNumber", reservation.room);
      localStorage.setItem("timeRange", timeRange);
      localStorage.setItem("eventDate", eventDate);

      // Wyświetl zapisane dane w konsoli
      console.log("Selected class details:");
      console.log({
        classId: reservation.id,
        className: reservation.class_name,
        roomNumber: reservation.room,
        timeRange: timeRange,
        eventDate: eventDate,
        dayOfMonth: dayOfMonth,
      });

      this.$router.push("/checkout");

      // Możesz tutaj dodać dodatkowe akcje, np. nawigację, komunikaty itp.
    },
    formatTime(time) {
      const [hours, minutes] = time.split(":").map(Number);
      const ampm = hours >= 12 ? "PM" : "AM";
      const formattedHours = hours % 12 || 12; // Przekonwertowanie na 12-godzinny format
      const formattedMinutes = minutes.toString().padStart(2, "0");
      return `${formattedHours}:${formattedMinutes} ${ampm}`;
    },
    async fetchFilterData() {
      try {
        const response = await axios.get("http://localhost:8000/main/filter");
        const data = response.data;

        this.classTypes = data.class_type;
        this.courseTypes = data.course_type;
        this.instructors = data.instructor;
      } catch (error) {
        console.error("Error fetching filter data:", error);
      }
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

      // Zamiana ID na nazwy przed wysłaniem zapytania
      const courseTypeName =
        this.courseTypes.find((course) => course.id === this.selectedCourseType)
          ?.name || "";
      const instructorName =
        this.instructors.find((instr) => instr.id === this.selectedInstructor)
          ?.name || "";
      const classTypeName =
        this.classTypes.find((clsType) => clsType.id === this.selectedClassType)
          ?.name || "";

      console.log("Request parameters:");
      console.log({
        month: monthString,
        course_type: courseTypeName,
        instructor: instructorName,
        class_type: classTypeName,
      });

      try {
        const response = await axios.get("http://localhost:8000/main/events", {
          params: {
            month: monthString,
            course_type: courseTypeName,
            instructor: instructorName,
            class_type: classTypeName,
          },
        });

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

        // Zamiana ID na nazwy przed wysłaniem zapytania
        const courseTypeName =
          this.courseTypes.find(
            (course) => course.id === this.selectedCourseType
          )?.name || "";
        const instructorName =
          this.instructors.find((instr) => instr.id === this.selectedInstructor)
            ?.name || "";
        const classTypeName =
          this.classTypes.find(
            (clsType) => clsType.id === this.selectedClassType
          )?.name || "";

        console.log("Request parameters:");
        console.log({
          day: dayOfMonth,
          month: month,
          year: year,
          course_type: courseTypeName,
          instructor: instructorName,
          class_type: classTypeName,
        });

        try {
          // Wysyłamy zapytanie POST do kontrolera Laravel
          const response = await axios.post(
            "http://localhost:8000/main/classes",
            {
              day: dayOfMonth,
              month: month,
              year: year,
              course_type: courseTypeName,
              instructor: instructorName,
              class_type: classTypeName,
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
  },
  watch: {
    selectedCourseType: "getEvents",
    selectedInstructor: "getEvents",
    selectedClassType: "getEvents",
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
  created() {
    this.fetchFilterData();
  },
  mounted() {
    this.getDateInfo();
    this.getEvents();
  },
};
</script>

<style lang="scss" scoped>
.plugin {
  .plugin-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: space-between;
    .plugin-left {
      width: calc(20% - 1rem);
      .filter {
        height: 800px;
        box-shadow: var(--box-shadow);
        padding: 1rem;
        border-radius: 15px;
        background-color: var(--white);
        h2 {
          font-size: 24px;
          font-weight: 600;
          color: var(--black);
          margin-bottom: 1rem;
        }
        .filter-item {
          margin-bottom: 1rem;
          select {
            cursor: pointer;
            width: 100%;
            height: 40px;
            font-size: 16px;
            border: none;
            color: var(--black);
            border-bottom: 1px solid var(--purple);
            background: url("@icons/arrow-down-menu.svg");
            background-repeat: no-repeat;
            background-position: 100%;
            -webkit-appearance: none;
            -moz-appearance: none;
          }
        }
      }
    }
    .plugin-right {
      width: calc(80% - 1rem);
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

            img {
              cursor: pointer;
            }

            img:first-child {
              margin-right: 1rem;
            }

            p {
              color: var(--black);
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
                color: var(--black);
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

.markings {
  .markings-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    .markings-box {
      box-shadow: var(--box-shadow);
      padding: 1rem;
      border-radius: 15px;
      margin-top: 2rem;
      .markings-text {
        h2 {
          font-size: 24px;
          font-weight: 500;
          color: var(--black);
          margin-bottom: 1rem;
        }
      }
      .markings-box-item {
        .markings-item:not(:last-child) {
          margin-bottom: 1rem;
        }
        .markings-item {
          p {
            font-size: 16px;
            color: var(--black);
            font-weight: 400;
            span {
              font-weight: 600;
            }
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
      img {
        cursor: pointer;
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
            margin-bottom: 1rem;
            font-weight: 400;
            font-size: 16px;
          }
        }
        .reservation-item-button {
          .reservation-item-btn {
            background-color: var(--purple);
            height: 40px;
            width: 100%;
            border: 2px solid var(--purple);
            border-radius: 5px;
            color: var(--white);
            font-size: 16px;
            cursor: pointer;
            transition: 0.5s;
            &:hover {
              background-color: var(--white);
              color: var(--purple);
            }
          }
        }
      }
    }
  }
}

@media screen and (max-width: 1500px) {
  .plugin {
    .plugin-content {
      flex-direction: column;
      .plugin-left {
        width: 100%;
        margin-bottom: 2rem;
        .filter {
          width: 100%;
          height: 100%;
        }
      }
      .plugin-right {
        width: 100%;
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
  .plugin {
    .plugin-content {
      width: 90%;
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
  .markings {
    .markings-content {
      width: 90%;
      .markings-box {
        .markings-box-item {
          flex-direction: column;
          .markings-item {
            margin-bottom: 1rem;
            p:not(:last-child) {
              margin-bottom: 1rem;
            }
            p {
              margin-bottom: 0;
            }
          }
        }
      }
    }
  }
}
</style>
