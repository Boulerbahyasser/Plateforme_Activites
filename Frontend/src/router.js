import { createRouter, createWebHistory } from 'vue-router';
import Contact from "@/components/Contact.vue";
import AboutUs from "@/components/AproposNous.vue";
import SignIn from '@/components/ConnexionPage.vue';
import SignUp from "@/components/InscriptionPage.vue";
import WelcomePage from "@/components/PageAccueil.vue";
import OffersPage from "@/components/OffersPage.vue";
import OfferDetails from "@/components/OfferDetails.vue";
import NotificationsPage from "@/components/NotificationsPage.vue";
import ActivityList from "@/components/ActivityList.vue";
import UserProfile from "@/components/UserProfile.vue";
import ChangePassword from "@/components/ChangePassword.vue";
import NotificationHistory from "@/components/NotificationHistory.vue";
import ChooseChildren from "@/components/ChooseChildren.vue";
import SelectSchedule from "@/components/SelectSchedule.vue";
import ForgetPassword from "@/components/ForgetPassword.vue";
import UnaUthorized from "@/components/UnaUthorized.vue";
import ParentRequests from "@/components/ParentRequests.vue";
import DemandeActivity from "@/components/DemandeActivity.vue";
import SubmitRequest from "@/components/SubmitRequest.vue";
import UserChildren from "@/components/UserChildren.vue";
import ChildPlanning from "@/components/ChildPlanning.vue";
import ActivityChildren from "@/components/ActivityChildren.vue";
// import AddChild from "@/components/AjouterEnfanr.vue";
import EditChild from "@/components/EditChild.vue";
import AdminPage from "@/components/ADMIN/AdminPage.vue";
import AjouterActivite from "@/components/ADMIN/AjouterActivite.vue";
import AjouterOffre from "@/components/ADMIN/AjouterOffre.vue";
import OfferDetailsAdmin from "@/components/ADMIN/OfferDetailsAdmin.vue";
import OffersListAdmin from "@/components/ADMIN/OffersListAdmin.vue";
import ListeEnfantActivites from "@/components/ADMIN/ListeEnfantActivites.vue";
import sidebar from "@/components/ADMIN/sidebar.vue";
import TopOffers from "@/components/ADMIN/TopOffers.vue"
import ActivitylistAdmin from "@/components/ADMIN/ActivitylistAdmin.vue"
import Animateur from "@/components/ADMIN/Animateur.vue"
import AnimateurList from "@/components/ANIMATEUR/AnimateurList.vue";
import AnimDetails from "@/components/ANIMATEUR/AnimDetails.vue";
import AnimeAddHoraire from "@/components/ANIMATEUR/AnimeAddHoraire.vue";
import AnimeDispHoraire from "@/components/ANIMATEUR/AnimeDispHoraire.vue";
import AnimeHoraire from "@/components/ANIMATEUR/AnimeHoraire.vue";
import AnimeOcuperHoraire from "@/components/ANIMATEUR/AnimeOcuperHoraire.vue";
import AnimateurDashboard from "@/components/ANIMATEUR/AnimateurDashboard.vue";

function adminGuard(to, from, next) {
  const userRole = localStorage.getItem('user_role');
  if (userRole === 'admin') {
    next();
  } else {
    next({ name: 'unauthorized' });
  }
}

const router = createRouter({
  history: createWebHistory(),
  routes: [

      { path: '/', component: WelcomePage, name: "WelcomePage" },
    { path: '/signin', component: SignIn, name: "SignIn" },
    { path: '/signup', component: SignUp, name: "SignUp" },
    { path:'/forgetpassword' , component:ForgetPassword , name:"forgetpassword"},
    { path:'/changepassword/:token' , component:ChangePassword , name:"changepassword"},
    { path: '/offerspage' , component:OffersPage , name:"OffersPage" },
    { path: '/offerdetails/:id' , component:OfferDetails , name:"offerdetails"},
    { path:'/activitylist/:offerId' , component:ActivityList , name:"activitylist"},
    { path:'/choosechildren' , component:ChooseChildren , name:"choosechildren"},
    { path:'/selectshedule/:activityId' , component:SelectSchedule , name:"selectshedule"},
    { path: '/submitrequest' , component:SubmitRequest , name:"submitrequest"},
    { path:'/notificationpage' , component:NotificationsPage , name:"notificationpage"},
    { path:'/notificationhistory' , component:NotificationHistory , name:"notificationhistory"},
    { path:'/userprofile' , component:UserProfile , name:"userprofile"} ,
    { path:'/unauthorized' , component:UnaUthorized ,name:"unauthorized"},
    { path: '/parentrequests', component: ParentRequests , name: "parentrequests"},
    { path: '/demandeactivity/:id', component: DemandeActivity, name: "demandeactivity"},
    { path: '/contact', component: Contact, name: "Contact" },
    { path: '/about', component: AboutUs, name: "AboutUs" },
    { path: '/userchildren', component: UserChildren, name: "userchildren" },
    { path: '/childplanning/:id', component: ChildPlanning, name: "childplanning" },
    // { pat: '/addChild' , component:AddChild , name:"addChild"},
    { path:'/editChild/:id' , component:EditChild , name:"editChild"},
{ path: '/activitychildren/:requestId/activities/:activityId/children', component: ActivityChildren, name: "activityChildren" },
    



{ path:'/AdminPage' , component:AdminPage , name:"AdminPage", beforeEnter: adminGuard},
    { path:'/AjouterActivite' , component:AjouterActivite , name:"AjouterActivite", beforeEnter: adminGuard},
      { path: '/ajouteroffre', component: AjouterOffre, name: "AjouterOffre"},
    { path:'/offer/:id' , component:OfferDetailsAdmin , name:"OfferDetailsAdmin", beforeEnter: adminGuard},
      { path: '/OffersListAdmin', component: OffersListAdmin, name: "OffersListAdmin", beforeEnter: adminGuard},
      { 
        path: '/unauthorized', 
        component: UnaUthorized, 
        name: "unauthorized"
      },
      {
        path: '/ListeEnfantActivites/:id',component:ListeEnfantActivites,name:"ListeEnfantActivites", beforeEnter: adminGuard
      },
      {
        path: '/sidebar',component:sidebar,name:"sidebar", beforeEnter: adminGuard
      },
      {
        path: '/TopOffers',component:TopOffers,name:"TopOffers", beforeEnter: adminGuard
      },
      {
        path: '/ActivitylistAdmin',component:ActivitylistAdmin,name:"ActivitylistAdmin", beforeEnter: adminGuard
      },
      {
        path: '/Animateur',component:Animateur,name:"Animateur", beforeEnter: adminGuard
      },

          { path:'/AnimateurList' , component:AnimateurList , name:"AnimateurList"},
    { path:'/AnimDetails' , component:AnimDetails , name:"AnimDetails"},
    { path:'/AnimeAddHoraire' , component:AnimeAddHoraire , name:"AnimeAddHoraire"},
    { path:'/AnimeDispHoraire' , component:AnimeDispHoraire , name:"AnimeDispHoraire"},
    { path:'/AnimeHoraire' , component:AnimeHoraire , name:"AnimeHoraire"},
    { path:'/AnimeOcuperHoraire' , component:AnimeOcuperHoraire , name:"AnimeOcuperHoraire"},
      { path:'/AnimateurDashboard' , component:AnimateurDashboard , name:"AnimateurDashboard"}
  ]
});

export default router;