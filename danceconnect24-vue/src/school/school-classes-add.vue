<template>
  <SchoolHeader />
  <div class="home">
    <div class="home-content">
      <div class="home-left">
        <p>Nickname: {{ nickname }}</p>
        <p>Email: {{ email }}</p>
        <p>My classes: {{ classCount }}</p>
        <p>My clients: {{ clientCount }}</p>
      </div>
      <div class="home-right">
        <h2>Add classes</h2>
        <div class="home-right-input">
          <label>Markings*</label>
          <input type="text" placeholder="Markings*" v-model="markings" />
        </div>
        <div class="home-right-input">
          <label>Class Type*</label>
          <input type="text" placeholder="Class Type*" v-model="classType" />
        </div>
        <div class="home-right-input">
          <label>Places*</label>
          <input type="number" placeholder="Places*" v-model="places" />
        </div>
        <div class="home-right-input">
          <label>Room*</label>
          <input type="text" placeholder="Room*" v-model="room" />
        </div>
        <div class="home-right-input">
          <label>Instructor*</label>
          <input type="text" placeholder="Instructor*" v-model="instructor" />
        </div>
        <div class="home-right-input">
          <label>Price*</label>
          <input type="number" placeholder="Price*" v-model="price" />
        </div>
        <div class="home-right-input">
          <label>Date*</label>
          <input
            type="text"
            placeholder="Date*"
            @click="toggleCalendar('start')"
            v-model="startDateInputValue"
            readonly
          />
          <div :class="['calendar-start', { active: isCalendarStartActive }]">
            <div class="calendar-header">
              <img
                src="@icons/arrow-left.svg"
                @click="previousMonth('start')"
              />
              <span>
                {{ startCalendar.currentMonthName }}
                {{ startCalendar.currentYear }}
              </span>
              <img src="@icons/arrow-right.svg" @click="nextMonth('start')" />
            </div>
            <div class="calendar-body">
              <div class="calendar-days">
                <span v-for="day in daysOfWeek" :key="day">{{ day }}</span>
              </div>
              <div class="calendar-dates">
                <span
                  v-for="(date, index) in startCalendar.calendarDates"
                  :key="index"
                  :class="{
                    today: isToday(date),
                    'empty-date': !date,
                    'selected-date':
                      date &&
                      selectedStartDate &&
                      date.toDateString() === selectedStartDate.toDateString(),
                    'range-date':
                      date &&
                      selectedStartDate &&
                      selectedEndDate &&
                      date >= selectedStartDate &&
                      date <= selectedEndDate,
                    'disabled-date': isDisabled(date),
                  }"
                  @click="!isDisabled(date) && date && selectStartDate(date)"
                >
                  {{ date ? date.getDate() : "" }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="home-right-input">
          <label>Time start*</label>
          <select v-model="timeStart">
            <option disabled selected>Time start*</option>
            <option value="12:00 AM">12:00 AM</option>
            <option value="12:30 AM">12:30 AM</option>
            <option value="1:00 AM">1:00 AM</option>
            <option value="1:30 AM">1:30 AM</option>
            <option value="2:00 AM">2:00 AM</option>
            <option value="2:30 AM">2:30 AM</option>
            <option value="3:00 AM">3:00 AM</option>
            <option value="3:30 AM">3:30 AM</option>
            <option value="4:00 AM">4:00 AM</option>
            <option value="4:30 AM">4:30 AM</option>
            <option value="5:00 AM">5:00 AM</option>
            <option value="5:30 AM">5:30 AM</option>
            <option value="6:00 AM">6:00 AM</option>
            <option value="6:30 AM">6:30 AM</option>
            <option value="7:00 AM">7:00 AM</option>
            <option value="7:30 AM">7:30 AM</option>
            <option value="8:00 AM">8:00 AM</option>
            <option value="8:30 AM">8:30 AM</option>
            <option value="9:00 AM">9:00 AM</option>
            <option value="9:30 AM">9:30 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="1:00 PM">1:00 PM</option>
            <option value="1:30 PM">1:30 PM</option>
            <option value="2:00 PM">2:00 PM</option>
            <option value="2:30 PM">2:30 PM</option>
            <option value="3:00 PM">3:00 PM</option>
            <option value="3:30 PM">3:30 PM</option>
            <option value="4:00 PM">4:00 PM</option>
            <option value="4:30 PM">4:30 PM</option>
            <option value="5:00 PM">5:00 PM</option>
            <option value="5:30 PM">5:30 PM</option>
            <option value="6:00 PM">6:00 PM</option>
            <option value="6:30 PM">6:30 PM</option>
            <option value="7:00 PM">7:00 PM</option>
            <option value="7:30 PM">7:30 PM</option>
            <option value="8:00 PM">8:00 PM</option>
            <option value="8:30 PM">8:30 PM</option>
            <option value="9:00 PM">9:00 PM</option>
            <option value="9:30 PM">9:30 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:30 PM">11:30 PM</option>
          </select>
        </div>
        <div class="home-right-input">
          <label>Time End*</label>
          <select v-model="timeEnd">
            <option disabled selected>Time end*</option>
            <option value="12:00 AM">12:00 AM</option>
            <option value="12:30 AM">12:30 AM</option>
            <option value="1:00 AM">1:00 AM</option>
            <option value="1:30 AM">1:30 AM</option>
            <option value="2:00 AM">2:00 AM</option>
            <option value="2:30 AM">2:30 AM</option>
            <option value="3:00 AM">3:00 AM</option>
            <option value="3:30 AM">3:30 AM</option>
            <option value="4:00 AM">4:00 AM</option>
            <option value="4:30 AM">4:30 AM</option>
            <option value="5:00 AM">5:00 AM</option>
            <option value="5:30 AM">5:30 AM</option>
            <option value="6:00 AM">6:00 AM</option>
            <option value="6:30 AM">6:30 AM</option>
            <option value="7:00 AM">7:00 AM</option>
            <option value="7:30 AM">7:30 AM</option>
            <option value="8:00 AM">8:00 AM</option>
            <option value="8:30 AM">8:30 AM</option>
            <option value="9:00 AM">9:00 AM</option>
            <option value="9:30 AM">9:30 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="1:00 PM">1:00 PM</option>
            <option value="1:30 PM">1:30 PM</option>
            <option value="2:00 PM">2:00 PM</option>
            <option value="2:30 PM">2:30 PM</option>
            <option value="3:00 PM">3:00 PM</option>
            <option value="3:30 PM">3:30 PM</option>
            <option value="4:00 PM">4:00 PM</option>
            <option value="4:30 PM">4:30 PM</option>
            <option value="5:00 PM">5:00 PM</option>
            <option value="5:30 PM">5:30 PM</option>
            <option value="6:00 PM">6:00 PM</option>
            <option value="6:30 PM">6:30 PM</option>
            <option value="7:00 PM">7:00 PM</option>
            <option value="7:30 PM">7:30 PM</option>
            <option value="8:00 PM">8:00 PM</option>
            <option value="8:30 PM">8:30 PM</option>
            <option value="9:00 PM">9:00 PM</option>
            <option value="9:30 PM">9:30 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:30 PM">11:30 PM</option>
          </select>
        </div>
        <div class="home-right-input">
          <label>Date Range*</label>
          <input
            type="text"
            placeholder="Date Range*"
            @click="toggleCalendarRange('range-start')"
            v-model="dateRangeInputValue"
            readonly
          />
          <div
            :class="[
              'calendar-range-start',
              { active: isCalendarRangeStartActive },
            ]"
          >
            <div class="calendar-header">
              <img
                src="@icons/arrow-left.svg"
                @click="previousMonth('range-start')"
              />
              <span>
                {{ rangeStartCalendar.currentMonthName }}
                {{ rangeStartCalendar.currentYear }}
              </span>
              <img
                src="@icons/arrow-right.svg"
                @click="nextMonth('range-start')"
              />
            </div>
            <div class="calendar-body">
              <div class="calendar-days">
                <span v-for="day in daysOfWeek" :key="day">{{ day }}</span>
              </div>
              <div class="calendar-dates">
                <span
                  v-for="(date, index) in rangeStartCalendar.calendarDates"
                  :key="index"
                  :class="{
                    today: isToday(date),
                    'empty-date': !date,
                    'selected-date':
                      date &&
                      selectedRangeStartDate &&
                      date.toDateString() ===
                        selectedRangeStartDate.toDateString(),
                    'range-date': isInRange(date),
                    'disabled-date': isDisabledRangeStartDate(date),
                  }"
                  @click="
                    !isDisabledRangeStartDate(date) &&
                      date &&
                      selectRangeStartDate(date)
                  "
                >
                  {{ date ? date.getDate() : "" }}
                </span>
              </div>
            </div>
          </div>

          <div
            :class="[
              'calendar-range-end',
              { active: isCalendarRangeEndActive },
            ]"
          >
            <div class="calendar-header">
              <img
                src="@icons/arrow-left.svg"
                @click="previousMonth('range-end')"
              />
              <span>
                {{ rangeEndCalendar.currentMonthName }}
                {{ rangeEndCalendar.currentYear }}
              </span>
              <img
                src="@icons/arrow-right.svg"
                @click="nextMonth('range-end')"
              />
            </div>
            <div class="calendar-body">
              <div class="calendar-days">
                <span v-for="day in daysOfWeek" :key="day">{{ day }}</span>
              </div>
              <div class="calendar-dates">
                <span
                  v-for="(date, index) in rangeEndCalendar.calendarDates"
                  :key="index"
                  :class="{
                    today: isToday(date),
                    'empty-date': !date,
                    'selected-date':
                      date &&
                      selectedRangeEndDate &&
                      date.toDateString() ===
                        selectedRangeEndDate.toDateString(),
                    'range-date': isInRange(date),
                    'disabled-date': isDisabledRangeEndDate(date),
                  }"
                  @click="
                    !isDisabledRangeEndDate(date) &&
                      date &&
                      selectRangeEndDate(date)
                  "
                >
                  {{ date ? date.getDate() : "" }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="home-right-button">
          <button class="home-right-btn" @click="add">
            <p>Add Classes</p>
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
      selectedStartDate: null,
      selectedEndDate: null,
      selectedRangeStartDate: null,
      selectedRangeEndDate: null,
      startCalendar: this.createCalendar(new Date()),
      rangeStartCalendar: this.createCalendar(new Date()),
      rangeEndCalendar: this.createCalendar(new Date()),
      isCalendarStartActive: false,
      isCalendarRangeStartActive: false,
      isCalendarRangeEndActive: false,
      startDateInputValue: "", // Nowe pole na wartość inputu
      dateRangeInputValue: "", // Nowe pole na wartość inputu dla zakresu dat
      monthNames: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],

      markings: "",
      classType: "",
      places: "",
      room: "",
      price: "",
      timeStart: "",
      timeEnd: "",
      instructor: "",

      nickname: "",
      email: "",
      classCount: 0, // Domyślnie 0, zaktualizowane po otrzymaniu danych
      clientCount: 0,
    };
  },
  computed: {
    daysOfWeek() {
      return ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
    },
    isInRange() {
      return (date) => {
        if (this.selectedRangeStartDate && this.selectedRangeEndDate) {
          return (
            date >= this.selectedRangeStartDate &&
            date <= this.selectedRangeEndDate
          );
        }
        return false;
      };
    },
  },
  methods: {
    async add() {
      const token = localStorage.getItem("token");
      const nickname = localStorage.getItem("nickname");

      function convertTo24HourFormat(time) {
        const [timePart, modifier] = time.split(" ");
        let [hours, minutes] = timePart.split(":");

        if (modifier === "PM" && hours !== "12") {
          hours = parseInt(hours, 10) + 12;
        }
        if (modifier === "AM" && hours === "12") {
          hours = "00";
        }

        return `${hours.padStart(2, "0")}:${minutes}`;
      }

      function getDatesBetween(startDate, endDate) {
        const dates = [];
        let currentDate = new Date(startDate);

        while (currentDate <= endDate) {
          dates.push(new Date(currentDate));
          currentDate.setDate(currentDate.getDate() + 1);
        }

        return dates;
      }

      const timeStart24 = convertTo24HourFormat(this.timeStart);
      const timeEnd24 = convertTo24HourFormat(this.timeEnd);

      const startDate = new Date(this.selectedRangeStartDate);
      const endDate = new Date(this.selectedRangeEndDate);

      const dates = getDatesBetween(startDate, endDate);

      const classesData = dates.map((date) => {
        const formattedDate = this.formatDate(date); // Użyj formatDate, który zwraca YYYY-MM-DD
        return {
          nickname: nickname,
          markings: this.markings,
          class_type: this.classType,
          places: this.places,
          room: this.room,
          price: this.price,
          date: formattedDate,
          time_start: timeStart24,
          time_end: timeEnd24,
          instructor: this.instructor,
        };
      });

      const data = { classes: classesData };

      try {
        const response = await axios.post(
          "http://localhost:8000/school/add",
          data,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        console.log("Response:", response.data);
      } catch (error) {
        console.error(error);
        alert("Error adding class");
      }
    },

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
    // Funkcja formatująca datę do DD.MM.YYYY
    formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, "0"); // Miesiące są indeksowane od 0
      const day = String(date.getDate()).padStart(2, "0");
      return `${year}-${month}-${day}`;
    },
    // Aktualizacja pola input dla pojedynczej daty
    selectStartDate(date) {
      if (!this.selectedEndDate || date <= this.selectedEndDate) {
        this.selectedStartDate = date;
        this.startDateInputValue = this.formatDate(date); // Ustawiamy wartość w polu input
        if (
          this.selectedEndDate &&
          this.selectedStartDate > this.selectedEndDate
        ) {
          this.selectedEndDate = this.selectedStartDate;
        }
        this.isCalendarStartActive = false; // Zamyka kalendarz po wyborze daty
      }
    },

    // Aktualizacja pola input dla początku zakresu dat
    selectRangeStartDate(date) {
      if (!this.selectedRangeEndDate || date <= this.selectedRangeEndDate) {
        this.selectedRangeStartDate = date;
        if (
          this.selectedRangeEndDate &&
          this.selectedRangeStartDate > this.selectedRangeEndDate
        ) {
          this.selectedRangeEndDate = this.selectedRangeStartDate;
        }
        // Aktualizujemy pole input tylko jeśli oba daty są wybrane
        if (this.selectedRangeEndDate) {
          this.dateRangeInputValue = `${this.formatDate(
            this.selectedRangeStartDate
          )} - ${this.formatDate(this.selectedRangeEndDate)}`;
        }
        this.isCalendarRangeStartActive = false;
        this.isCalendarRangeEndActive = true; // Przejście do wyboru końcowej daty
      }
    },

    // Aktualizacja pola input dla końca zakresu dat
    selectRangeEndDate(date) {
      if (!this.selectedRangeStartDate || date >= this.selectedRangeStartDate) {
        this.selectedRangeEndDate = date;
        this.dateRangeInputValue = `${this.formatDate(
          this.selectedRangeStartDate
        )} - ${this.formatDate(this.selectedRangeEndDate)}`; // Ustawiamy wartość w polu input
        this.isCalendarRangeEndActive = false;
      }
    },

    // Pozostałe metody bez zmian...
    isDisabledRangeStartDate(date) {
      const today = new Date();
      return date && date < today;
    },
    isDisabledRangeEndDate(date) {
      return this.selectedRangeStartDate && date < this.selectedRangeStartDate;
    },
    createCalendar(date) {
      const currentMonth = date.getMonth();
      const currentYear = date.getFullYear();
      return {
        currentMonth,
        currentYear,
        currentMonthName: date.toLocaleString("en", { month: "long" }),
        calendarDates: this.getCalendarDates(currentYear, currentMonth),
      };
    },
    getCalendarDates(year, month) {
      const start = new Date(year, month, 1);
      const end = new Date(year, month + 1, 0);
      const dates = [];

      let firstDayOfWeek = start.getDay();
      if (firstDayOfWeek === 0) {
        firstDayOfWeek = 6;
      } else {
        firstDayOfWeek -= 1;
      }

      for (let i = 0; i < firstDayOfWeek; i++) {
        dates.push(null);
      }

      for (let i = 1; i <= end.getDate(); i++) {
        dates.push(new Date(year, month, i));
      }

      const totalDays = dates.length;
      const totalWeeks = Math.ceil(totalDays / 7) * 7;
      for (let i = totalDays; i < totalWeeks; i++) {
        dates.push(null);
      }

      return dates;
    },
    previousMonth(calendar) {
      if (calendar === "start") {
        this.startCalendar = this.createCalendar(
          new Date(
            this.startCalendar.currentYear,
            this.startCalendar.currentMonth - 1
          )
        );
      } else if (calendar === "range-start") {
        this.rangeStartCalendar = this.createCalendar(
          new Date(
            this.rangeStartCalendar.currentYear,
            this.rangeStartCalendar.currentMonth - 1
          )
        );
      } else if (calendar === "range-end") {
        this.rangeEndCalendar = this.createCalendar(
          new Date(
            this.rangeEndCalendar.currentYear,
            this.rangeEndCalendar.currentMonth - 1
          )
        );
      }
    },
    nextMonth(calendar) {
      if (calendar === "start") {
        this.startCalendar = this.createCalendar(
          new Date(
            this.startCalendar.currentYear,
            this.startCalendar.currentMonth + 1
          )
        );
      } else if (calendar === "range-start") {
        this.rangeStartCalendar = this.createCalendar(
          new Date(
            this.rangeStartCalendar.currentYear,
            this.rangeStartCalendar.currentMonth + 1
          )
        );
      } else if (calendar === "range-end") {
        this.rangeEndCalendar = this.createCalendar(
          new Date(
            this.rangeEndCalendar.currentYear,
            this.rangeEndCalendar.currentMonth + 1
          )
        );
      }
    },
    isToday(date) {
      const today = new Date();
      return (
        date &&
        date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
      );
    },
    isDisabled(date) {
      const today = new Date();
      const startOfDisabledRange = new Date(today);
      startOfDisabledRange.setDate(today.getDate() - 1);

      const endOfDisabledRange = new Date(today);
      endOfDisabledRange.setFullYear(
        today.getFullYear() + 1,
        today.getMonth(),
        today.getDate() - 1
      );

      return date && (date < startOfDisabledRange || date > endOfDisabledRange);
    },
    updateStartCalendar() {
      if (this.selectedStartDate) {
        this.startCalendar = this.createCalendar(
          new Date(this.selectedStartDate)
        );
      }
    },
    updateEndCalendar() {
      if (this.selectedEndDate) {
        this.endCalendar = this.createCalendar(new Date(this.selectedEndDate));
      }
    },
    toggleCalendar(calendar) {
      if (calendar === "start") {
        this.isCalendarStartActive = !this.isCalendarStartActive;
        if (this.isCalendarStartActive) {
          this.isCalendarRangeStartActive = false;
          this.isCalendarRangeEndActive = false;
        }
      }
    },

    toggleCalendarRange(calendar) {
      if (calendar === "range-start") {
        this.isCalendarRangeStartActive = !this.isCalendarRangeStartActive;
        this.isCalendarRangeEndActive = this.isCalendarRangeStartActive; // Ustawia ten sam stan aktywacji dla końca zakresu
        if (this.isCalendarRangeStartActive) {
          this.isCalendarStartActive = false;
        }
      } else if (calendar === "range-end") {
        this.isCalendarRangeEndActive = !this.isCalendarRangeEndActive;
        if (this.isCalendarRangeEndActive) {
          this.isCalendarRangeStartActive = true; // Ustawia kalendarz początkowy na aktywny, jeśli końcowy jest aktywny
          this.isCalendarStartActive = false;
        }
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
  mounted() {
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
      padding: 1rem;
      box-shadow: var(--box-shadow);
      border-radius: 15px;
      height: 100%;
      h2 {
        font-size: 24px;
        color: var(--black);
        font-weight: 500;
        margin-bottom: 1rem;
      }
      .home-right-input {
        display: flex;
        flex-direction: column;
        position: relative;
        label {
          font-size: 16px;
          font-weight: 500;
          color: var(--black);
        }
        input {
          margin-top: 1rem;
          margin-bottom: 1rem;
          border: none;
          border-bottom: 1px solid var(--purple);
          font-size: 16px;
          height: 40px;
          color: var(--black);
        }
        select {
          margin-top: 1rem;
          margin-bottom: 1rem;
          border: none;
          border-bottom: 1px solid var(--purple);
          font-size: 16px;
          height: 40px;
          color: var(--black);
        }
        .calendar-start {
          background-color: var(--white);
          z-index: 96;
          box-shadow: var(--box-shadow);
          position: absolute;
          top: 85px;
          width: 300px;
          padding: 1rem;
          margin: auto;
          border: 1px solid var(--grey);
          border-radius: 10px;
          display: none;
          &.active {
            display: block;
          }
          .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            img {
              cursor: pointer;
            }
            span {
              font-size: 14px;
              color: var(--black);
              font-weight: 600;
            }
          }
          .calendar-body {
            display: flex;
            flex-direction: column;
            .calendar-days {
              display: flex;
              flex-wrap: wrap;
              margin: -0.5rem;
              span {
                font-size: 14px;
                color: var(--grey);
                font-weight: 600;
              }
            }
            .calendar-dates {
              display: flex;
              flex-wrap: wrap;
              margin: -0.5rem;
              span {
                font-size: 14px;
              }
            }
          }
          .calendar-days {
            margin-bottom: 0.5rem;
            span {
              flex: 1 0 14.28%;
              text-align: center;
              padding: 0.5rem;
              box-sizing: border-box;
            }
          }
          .calendar-dates {
            padding-top: 20px;
            span {
              flex: 1 0 14.28%;
              text-align: center;
              padding: 0.5rem;
              box-sizing: border-box;
              cursor: pointer;
              &.empty-date {
                background: transparent;
              }
              &.selected-date {
                background-color: var(--purple);
                color: var(--white);
                font-weight: 600;
              }
              &.range-date {
                background-color: var(--light-purple);
              }
              &.disabled-date {
                color: var(--grey);
                cursor: not-allowed;
              }
            }
          }
        }
        .calendar-range-end {
          background-color: var(--white);
          z-index: 96;
          box-shadow: var(--box-shadow);
          position: absolute;
          top: 85px;
          left: 316px;
          width: 300px;
          padding: 1rem;
          margin: auto;
          border: 1px solid var(--grey);
          border-radius: 10px;
          display: none;
          &.active {
            display: block;
          }
          .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            img {
              cursor: pointer;
            }
            span {
              font-size: 14px;
              color: var(--black);
              font-weight: 600;
            }
          }
          .calendar-body {
            display: flex;
            flex-direction: column;
            .calendar-days {
              display: flex;
              flex-wrap: wrap;
              margin: -0.5rem;
              span {
                font-size: 14px;
                color: var(--grey);
                font-weight: 600;
              }
            }
            .calendar-dates {
              display: flex;
              flex-wrap: wrap;
              margin: -0.5rem;
              span {
                font-size: 14px;
              }
            }
          }
          .calendar-days {
            margin-bottom: 0.5rem;
            span {
              flex: 1 0 14.28%;
              text-align: center;
              padding: 0.5rem;
              box-sizing: border-box;
            }
          }
          .calendar-dates {
            padding-top: 20px;
            span {
              flex: 1 0 14.28%;
              text-align: center;
              padding: 0.5rem;
              box-sizing: border-box;
              cursor: pointer;
              &.empty-date {
                background: transparent;
              }
              &.selected-date {
                background-color: var(--purple);
                color: var(--white);
                font-weight: 600;
              }
              &.range-date {
                background-color: var(--light-purple);
              }
              &.disabled-date {
                color: var(--grey);
                cursor: not-allowed;
              }
            }
          }
        }
        .calendar-range-start {
          background-color: var(--white);
          z-index: 96;
          box-shadow: var(--box-shadow);
          position: absolute;
          top: 85px;
          width: 300px;
          padding: 1rem;
          margin: auto;
          border: 1px solid var(--grey);
          border-radius: 10px;
          display: none;
          &.active {
            display: block;
          }
          .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            img {
              cursor: pointer;
            }
            span {
              font-size: 14px;
              color: var(--black);
              font-weight: 600;
            }
          }
          .calendar-body {
            display: flex;
            flex-direction: column;
            .calendar-days {
              display: flex;
              flex-wrap: wrap;
              margin: -0.5rem;
              span {
                font-size: 14px;
                color: var(--grey);
                font-weight: 600;
              }
            }
            .calendar-dates {
              display: flex;
              flex-wrap: wrap;
              margin: -0.5rem;
              span {
                font-size: 14px;
              }
            }
          }
          .calendar-days {
            margin-bottom: 0.5rem;
            span {
              flex: 1 0 14.28%;
              text-align: center;
              padding: 0.5rem;
              box-sizing: border-box;
            }
          }
          .calendar-dates {
            padding-top: 20px;
            span {
              flex: 1 0 14.28%;
              text-align: center;
              padding: 0.5rem;
              box-sizing: border-box;
              cursor: pointer;
              &.empty-date {
                background: transparent;
              }
              &.selected-date {
                background-color: var(--purple);
                color: var(--white);
                font-weight: 600;
              }
              &.range-date {
                background-color: var(--light-purple);
              }
              &.disabled-date {
                color: var(--grey);
                cursor: not-allowed;
              }
            }
          }
        }
      }
      .home-right-button {
        .home-right-btn {
          background-color: var(--purple);
          width: 100%;
          height: 40px;
          border: 2px solid var(--purple);
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
        .home-right-input {
          .calendar-start {
            width: 100%;
          }
          .calendar-range-start {
            width: 100%;
          }
          .calendar-range-end {
            width: 100%;
            left: 0;
            top: 380px;
          }
        }
      }
    }
  }
}
</style>
