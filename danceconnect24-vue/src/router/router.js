import { createRouter, createWebHistory } from "vue-router";
import MainPage from "@subpages/main-page.vue";
import Price from "@subpages/price.vue";
import Contact from "@subpages/contact.vue";
import AboutUs from "@subpages/about-us.vue";
import OfferForSchools from "@subpages/offer-for-schools.vue";
import Calendar from "@subpages/calendar.vue";
import Checkout from "@subpages/checkout.vue";
import BuySchoolAccount from "@subpages/buy-school-account.vue";
import PolicyPrivacy from "@subpages/privacy-policy.vue";
import Regulations from "@subpages/regulations.vue";

import Register from "@auth/register.vue";
import Login from "@auth/login.vue";
import RecoverPassword from "@auth/recover-password.vue";
import ResetPassword from "@auth/reset-password.vue";

import UserPage from "@user/user-page.vue";
import UserClasses from "@user/user-classes.vue";
import UserSettings from "@user/user-settings.vue";
import UserChangeEmail from "@user/user-change-email.vue";
import UserChangePassword from "@user/user-change-password.vue";

import SchoolPage from "@school/school-page.vue";
import SchoolClasses from "@school/school-classes.vue";
import SchoolClassesAdd from "@school/school-classes-add.vue";
import SchoolClassesDelete from "@school/school-classes-delete.vue";
import SchoolClassesEdit from "@school/school-classes-edit.vue";
import SchoolClients from "@school/school-clients.vue";
import SchoolSettings from "@school/school-settings.vue";
import SchoolChangeEmail from "@school/school-change-email.vue";
import SchoolChangePassword from "@school/school-change-password.vue";

import AdminPage from "@admin/admin-page.vue";
import AdminUsersList from "@admin/admin-users-list.vue";
import AdminSchoolList from "@admin/admin-school-list.vue";
import AdminSchoolClients from "@admin/admin-school-clients.vue";
import AdminSettings from "@admin/admin-settings.vue";
import AdminChangeEmail from "@admin/admin-change-email.vue";
import AdminChangePassword from "@admin/admin-change-password.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: MainPage,
      name: "main-page",
      meta: {
        title: "Danceconnect24 - Main Page",
        description:
          "Welcome to Danceconnect24! Discover how our app can help manage dance classes and school accounts. Explore all features and start your dance journey.",
        canonical: "",
      },
    },
    {
      path: "/price",
      component: Price,
      name: "price",
      meta: {
        title: "Danceconnect24 - Pricing",
        description:
          "Check out our pricing for Danceconnect24 services. We offer various plans to fit the needs of your dance school.",
        canonical: "",
      },
    },
    {
      path: "/contact",
      component: Contact,
      name: "contact",
      meta: {
        title: "Danceconnect24 - Contact Us",
        description:
          "Have questions? Get in touch with us through the contact form on Danceconnect24. We're here to assist with any inquiries about our app.",
        canonical: "",
      },
    },
    {
      path: "/about-us",
      component: AboutUs,
      name: "about-us",
      meta: {
        title: "Danceconnect24 - About Us",
        description:
          "Learn more about Danceconnect24 and our mission. Meet the team behind the app and find out how we're transforming dance management.",
        canonical: "",
      },
    },
    {
      path: "/offer-for-schools",
      component: OfferForSchools,
      name: "offer-for-schools",
      meta: {
        title: "Danceconnect24 - Offer for Schools",
        description:
          "Explore our special offers for dance schools. Danceconnect24 provides tailored solutions to help schools manage their dance programs efficiently.",
        canonical: "",
      },
    },
    {
      path: "/calendar",
      component: Calendar,
      name: "calendar",
      meta: {
        title: "Danceconnect24 - Calendar",
        description:
          "Manage your dance schedule with our integrated calendar. Plan and organize classes effortlessly with Danceconnect24.",
        canonical: "",
      },
    },
    {
      path: "/checkout",
      component: Checkout,
      name: "checkout",
      meta: {
        title: "Danceconnect24 - Checkout",
        description:
          "Complete your purchase and finalize your order with Danceconnect24. Secure and straightforward checkout process for your convenience.",
        canonical: "",
      },
    },
    {
      path: "/buy-school-account",
      component: BuySchoolAccount,
      name: "buy-school-account",
      meta: {
        title: "Danceconnect24 - Buy School Account",
        description:
          "Purchase a school account with Danceconnect24 and unlock all the features to manage your dance school efficiently.",
        canonical: "",
      },
    },
    {
      path: "/policy-privacy",
      component: PolicyPrivacy,
      name: "policy-privacy",
      meta: {
        title: "Danceconnect24 - Privacy Policy",
        description:
          "Read our Privacy Policy to understand how Danceconnect24 handles your data and protects your privacy.",
        canonical: "",
      },
    },
    {
      path: "/regulations",
      component: Regulations,
      name: "regulations",
      meta: {
        title: "Danceconnect24 - Terms and Conditions",
        description:
          "Review the terms and conditions for using Danceconnect24. Learn about your rights and obligations as a user of our platform.",
        canonical: "",
      },
    },

    {
      path: "/register",
      component: Register,
      name: "register",
      meta: {
        title: "Danceconnect24 - Register",
        description:
          "Create an account on Danceconnect24 and start managing your dance classes and school account today.",
        canonical: "",
      },
    },
    {
      path: "/login",
      component: Login,
      name: "login",
      meta: {
        title: "Danceconnect24 - Login",
        description:
          "Log in to Danceconnect24 to access your account and manage your dance classes and school account.",
        canonical: "",
      },
    },
    {
      path: "/recover-password",
      component: RecoverPassword,
      name: "recover-password",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/reset-password",
      component: ResetPassword,
      name: "reset-password",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/user-page",
      component: UserPage,
      name: "user-page",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/user-classes",
      component: UserClasses,
      name: "user-classes",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/user-settings",
      component: UserSettings,
      name: "user-settings",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/user-settings",
      component: UserSettings,
      name: "user-settings",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/user-change-email",
      component: UserChangeEmail,
      name: "user-change-email",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/user-change-password",
      component: UserChangePassword,
      name: "user-change-password",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-page",
      component: SchoolPage,
      name: "school-page",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-classes",
      component: SchoolClasses,
      name: "school-classes",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-classes-add",
      component: SchoolClassesAdd,
      name: "school-classes-add",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-classes-delete",
      component: SchoolClassesDelete,
      name: "school-classes-delete",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-classes-edit",
      component: SchoolClassesEdit,
      name: "school-classes-edit",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-clients",
      component: SchoolClients,
      name: "school-clients",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-settings",
      component: SchoolSettings,
      name: "school-settings",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-change-email",
      component: SchoolChangeEmail,
      name: "school-change-email",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/school-change-password",
      component: SchoolChangePassword,
      name: "school-change-password",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/admin-page",
      component: AdminPage,
      name: "admin-page",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/admin-users-list",
      component: AdminUsersList,
      name: "admin-users-list",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/admin-school-list",
      component: AdminSchoolList,
      name: "admin-school-list",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/admin-school-clients",
      component: AdminSchoolClients,
      name: "admin-school-clients",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/admin-settings",
      component: AdminSettings,
      name: "admin-settings",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/admin-change-email",
      component: AdminChangeEmail,
      name: "admin-change-email",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
    {
      path: "/admin-change-password",
      component: AdminChangePassword,
      name: "admin-change-password",
      meta: {
        title: "",
        description: "",
        canonical: "",
      },
      content: "noindex, nofollow",
    },
  ],
});

router.beforeEach((to, from, next) => {
  window.scrollTo(0, 0);
  const meta = to.meta;

  if (meta.title) {
    document.title = meta.title;
  }

  if (meta.description) {
    const descriptionMetaTag = document.querySelector(
      'meta[name="description"]'
    );
    if (descriptionMetaTag) {
      descriptionMetaTag.setAttribute("content", meta.description);
    } else {
      const newDescriptionMetaTag = document.createElement("meta");
      newDescriptionMetaTag.name = "description";
      newDescriptionMetaTag.content = meta.description;
      document.head.appendChild(newDescriptionMetaTag);
    }
  }

  if (meta.canonical) {
    let linkCanonical = document.querySelector('link[rel="canonical"]');
    if (linkCanonical) {
      linkCanonical.setAttribute("href", meta.canonical);
    } else {
      linkCanonical = document.createElement("link");
      linkCanonical.setAttribute("rel", "canonical");
      linkCanonical.setAttribute("href", meta.canonical);
      document.head.appendChild(linkCanonical);
    }
  }
  next();
});

export default router;
