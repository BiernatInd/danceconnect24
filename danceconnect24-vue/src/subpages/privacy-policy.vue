<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <h1>Privacy Policy for DanceStudio Platform</h1>
      <p>Last Updated: 01.02.2024</p>
      <p>
        <span>Introduction:</span> Welcome to DanceStudio Platform
        (&quot;we,&quot; &quot;our,&quot; or &quot;us&quot;). This Privacy
        Policy outlines how we collect, use, disclose, and safeguard your
        personal information when you use our platform. By accessing or using
        the DanceStudio Platform, you agree to the terms of this Privacy Policy.
      </p>

      <p>
        <span>Information We Collect:</span> We collect both personal and
        non-personal information to provide and improve our services. Personal
        information may include, but is not limited to, your name, contact
        information, payment details, and any other information you voluntarily
        provide.
      </p>
      <p>
        <span> How We Use Your Information:</span> We use your information for
        the following purposes:
      </p>
      <ul>
        <li>To facilitate and personalize your experience on the platform.</li>
        <li>To process payments securely and efficiently.</li>
        <li>
          To communicate with you regarding your bookings, updates, and
          promotions.
        </li>
        <li>4. To improve our platform, services, and user experience.</li>
        <li>To enforce our terms and policies.</li>
      </ul>
      <p>
        <span>Information Sharing:</span> We may share your information with:
      </p>
      <ul>
        <li>
          DanceStudio24 app for seamless integration and enhanced user
          experience.
        </li>
        <li>Payment processors for secure transaction processing.</li>
        <li>
          Third-party service providers assisting us with platform
          functionalities.
        </li>
      </ul>
      <p>
        We will not sell, lease, or share your personal information with third
        parties for their promotional purposes.
      </p>
      <p>
        <span>Security Measures:</span> We prioritize the security of your
        information and employ industry-standard measures to protect against
        unauthorized access, disclosure, alteration, or destruction of your
        personal data.
      </p>
      <p><span>Your Choices:</span> You can:</p>
      <ul>
        <li>
          Review and update your personal information through your account
          settings.
        </li>
        <li>
          Opt-out of promotional communications by using the unsubscribe link
          provided in emails.
        </li>
      </ul>
      <p>
        <span>Contact Information:</span> For any privacy-related inquiries or
        concerns, please contact us at contact.danceapp24@gmail.com.
      </p>
      <p>
        <span>Changes to this Privacy Policy:</span> We may update this Privacy
        Policy from time to time. Any changes will be effective upon posting the
        updated policy on our platform. Please review this Privacy Policy
        periodically.
      </p>
      <p>
        By using our platform, you consent to the terms of this Privacy Policy.
      </p>
      <p>Thank you for trusting DanceStudio Platform with your information.</p>
      <p>Email: contact.danceapp24@gmail.com</p>
    </div>
  </div>
  <MainFooter />
</template>

<script>
import MainHeader from "@main-components/main-header.vue";
import MainFooter from "@main-components/main-footer.vue";

export default {
  components: {
    MainHeader,
    MainFooter,
  },
};
</script>

<style lang="scss" scoped>
.home {
  width: 100%;
  padding-top: 150px;
  .home-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    h1 {
      font-size: 24px;
      color: var(--black);
      font-weight: 600;
      margin-bottom: 1rem;
    }
    p {
      margin-bottom: 1rem;
      font-size: 20px;
      color: var(--black);
      font-weight: 400;
      span {
        font-weight: 600;
      }
    }
    ul {
      width: 95%;
      margin-left: auto;
      margin-right: auto;
      li {
        margin-bottom: 1rem;
        font-size: 16px;
        color: var(--black);
        font-weight: 400;
      }
    }
  }
}

@media screen and (max-width: 1200px) {
  .home {
    .home-content {
      width: 90%;
      h2 {
        font-size: 20px;
      }
      p {
        font-size: 16px;
      }
      ul {
        width: 80%;
        li {
          font-size: 14px;
        }
      }
    }
  }
}
</style>
