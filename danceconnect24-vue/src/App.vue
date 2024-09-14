<template>
  <div class="main">
    <router-view></router-view>
  </div>
</template>

<style>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap");
</style>

<style lang="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Montserrat", sans-serif;
}

body {
  background-color: var(--white);
}

.main {
  max-width: 1920px;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  background-color: var(--white);
}

:root {
  --white: #ffffff;
  --black: #2b2929;
  --light-purple: rgb(131, 38, 214, 0.5);
  --pink: #d61099;
  --second-pink: #b718b0;
  --purple: #8326d6;
  --grey: #a7a7a7;
  --gradient: linear-gradient(90deg, #d61099, #8326d6);
  --box-shadow: 0px 0px 10px 0px rgb(131, 38, 214, 0.5);
}

@media screen and (max-width: 1024px) {
  .main {
    width: 100%;
  }
}
</style>
