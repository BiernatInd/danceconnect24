<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <h1>DanceStudio Platform Statute</h1>
      <h2>Article 1: Name and Purpose</h2>
      <p>
        1.1. The platform is named DanceStudio Platform, hereinafter referred to
        as &quot;the Platform.&quot;
      </p>
      <p>
        1.2. The purpose of the Platform is to provide a centralized system for
        dance studios and enthusiasts to connect, book classes, and enhance the
        overall dance community experience.
      </p>
      <h2>Article 2: Ownership and Management</h2>
      <p>
        2.1. The Platform is owned and operated by [Your Company Name],
        hereinafter referred to as &quot;the Company.&quot;
      </p>
      <p>
        2.2. The Company reserves the right to manage, modify, and enhance the
        Platform to ensure its effectiveness and alignment with its objectives.
      </p>
      <h2>Article 3: User Rights and Responsibilities</h2>
      <p>
        3.1. Users of the Platform, including dance studios and individuals,
        have the right to access and utilize the services in accordance with the
        Platform&#39;s terms.
      </p>
      <p>
        3.2. Users are responsible for providing accurate and up-to-date
        information during registration and usage of the Platform.
      </p>
      <h2>Article 4: Platform Services</h2>
      <p>
        4.1. The Platform offers services such as online class booking, payment
        processing, and dance community features.
      </p>
      <p>
        4.2. The Company may introduce new services or modify existing ones to
        enhance user experience and meet evolving needs.
      </p>
      <h2>Article 5: Subscription Model</h2>
      <p>
        5.1. Dance studios have the option to subscribe to a premium service, as
        outlined in the Privacy Policy, to access additional benefits and
        features.
      </p>
      <p>
        5.2. The subscription fee will be communicated to dance studios, and
        changes, if any, will be notified in advance.
      </p>
      <h2>Article 6: Code of Conduct</h2>
      <p>
        6.1. Users are expected to adhere to a code of conduct that promotes a
        positive and respectful environment within the Platform.
      </p>
      <p>
        6.2. Any form of abusive, discriminatory, or inappropriate behavior may
        result in the suspension or termination of user accounts.
      </p>
      <h2>Article 7: Privacy and Data Protection</h2>
      <p>
        7.1. The Platform is committed to protecting user privacy, as outlined
        in the Privacy Policy.
      </p>
      <p>
        7.2. Users are encouraged to review and understand the Privacy Policy,
        which governs the collection, use, and protection of personal
        information.
      </p>
      <h2>Article 8: Amendments and Updates</h2>
      <p>
        8.1. The Company reserves the right to amend or update the
        Platform&#39;s statute and services. Users will be informed of any
        significant changes.
      </p>
      <h2>Article 9: Governing Law</h2>
      <p>
        9.1. This statute is governed by the laws of [Jurisdiction]. Any
        disputes arising shall be subject to the exclusive jurisdiction of the
        courts in [Jurisdiction].
      </p>
      <h2>Article 10: Contact Information</h2>
      <p>
        10.1. For inquiries or concerns related to the Platform&#39;s statute,
        users may contact the Company at contact.danceapp24@gmail.com.
      </p>
      <p>
        This statute is effective as of [Date]. Users are advised to review the
        statute periodically for any updates or changes.
      </p>
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
    h2 {
      font-size: 20px;
      color: var(--black);
      font-weight: 600;
      margin-bottom: 1rem;
    }
    p {
      margin-bottom: 1rem;
      font-size: 16px;
      color: var(--black);
      font-weight: 400;
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
      h2 {
        font-size: 16px;
      }
      p {
        font-size: 14px;
      }
    }
  }
}
</style>
