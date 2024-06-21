import { createRouter, createWebHistory } from 'vue-router';
import Contact from "@/components/Contact.vue";
import OffersPage from "@/components/PARENT/OffersPage.vue";
import OfferDetails from "@/components/PARENT/OfferDetails.vue";
import NotificationsPage from "@/components/PARENT/NotificationsPage.vue";
import ActivityList from "@/components/PARENT/ActivityList.vue";
import UserProfile from "@/components/PARENT/UserProfile.vue";
import ChangePassword from "@/components/AUTH/ChangePassword.vue";
import NotificationHistory from "@/components/PARENT/NotificationHistory.vue";
import ChooseChildren from "@/components/PARENT/ChooseChildren.vue";
import SelectSchedule from "@/components/PARENT/SelectSchedule.vue";
import ForgetPassword from "@/components/AUTH/ForgetPassword.vue";
import UnaUthorized from "@/components/UnaUthorized.vue";
import ParentRequests from "@/components/PARENT/ParentRequests.vue";
import DemandeActivity from "@/components/PARENT/DemandeActivity.vue";
import SubmitRequest from "@/components/PARENT/SubmitRequest.vue";
import UserChildren from "@/components/PARENT/UserChildren.vue";
import ChildPlanning from "@/components/PARENT/ChildPlanning.vue";
import ActivityChildren from "@/components/PARENT/ActivityChildren.vue";
import EditChild from "@/components/PARENT/EditChild.vue";
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
import AnimeAddHoraire from "@/components/ANIMATEUR/AnimeAddHoraire.vue";
import AnimeDispHoraire from "@/components/ANIMATEUR/AnimeDispHoraire.vue";
import AnimeHoraire from "@/components/ANIMATEUR/AnimeHoraire.vue";
import AnimeOcuperHoraire from "@/components/ANIMATEUR/AnimeOcuperHoraire.vue";
import AnimateurDashboard from "@/components/ANIMATEUR/AnimateurDashboard.vue";
import PageAccueil from "@/components/PageAccueil.vue";
import ConnexionPage from "@/components/AUTH/ConnexionPage.vue";
import InscriptionPage from "@/components/AUTH/InscriptionPage.vue";
import AproposNous from "@/components/AproposNous.vue";
import AjouterEnfant from "@/components/PARENT/AjouterEnfant.vue";
import FAQ from "@/components/FAQ.vue";

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

      { path: '/', component: PageAccueil, name: "PageAccueil" },
    { path: '/ConnexionPage', component: ConnexionPage, name: "ConnexionPage" },
    { path: '/InscriptionPage', component: InscriptionPage, name: "InscriptionPage" },
    { path:'/forgetpassword' , component:ForgetPassword , name:"forgetpassword"},
    { path:'/changepassword/:token' , component:ChangePassword , name:"changepassword"},
    { path: '/offerspage' , component:OffersPage , name:"OffersPage" ,  meta: { requiresAuth: true , roles: ['parent'] } },
    { path: '/offerdetails/:id' , component:OfferDetails , name:"offerdetails" , meta: { requiresAuth: true , roles: ['parent'] }},
    { path:'/activitylist/:offerId' , component:ActivityList , name:"activitylist"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path:'/choosechildren' , component:ChooseChildren , name:"choosechildren"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path:'/selectshedule/:activityId' , component:SelectSchedule , name:"selectshedule"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path: '/submitrequest' , component:SubmitRequest , name:"submitrequest"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path:'/notificationpage' , component:NotificationsPage , name:"notificationpage"  ,  meta: { requiresAuth: true , roles: ['parent' , 'admin'] }},
    { path:'/notificationhistory' , component:NotificationHistory , name:"notificationhistory"  ,  meta: { requiresAuth: true , roles: ['parent', 'admin'] }},
    { path:'/userprofile' , component:UserProfile , name:"userprofile" } ,
    { path:'/unauthorized' , component:UnaUthorized ,name:"unauthorized"},
    { path: '/parentrequests', component: ParentRequests , name: "parentrequests"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path: '/demandeactivity/:id', component: DemandeActivity, name: "demandeactivity"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path: '/contact', component: Contact, name: "Contact" },
    { path: '/AproposNous', component: AproposNous, name: "AproposNous" },
    { path: '/userchildren', component: UserChildren, name: "userchildren"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path: '/childplanning/:id', component: ChildPlanning, name: "childplanning"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path:'/editChild/:id' , component:EditChild , name:"editChild"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path: '/activitychildren/:requestId/activities/:activityId/children', component: ActivityChildren, name: "activityChildren"  ,  meta: { requiresAuth: true , roles: ['parent'] } } ,
    { path:'/AdminPage' , component:AdminPage , name:"AdminPage"},
    { path:'/AjouterEnfant' , component:AjouterEnfant , name:"AjouterEnfant"  ,  meta: { requiresAuth: true , roles: ['parent'] }},
    { path:'/FAQ' , component:FAQ , name:"FAQ"},

    


//Admin
      { path:'/AdminPage' , component:AdminPage , name:"AdminPage", beforeEnter: adminGuard},
      { path:'/AjouterActivite' , component:AjouterActivite , name:"AjouterActivite", beforeEnter: adminGuard},
      { path: '/ajouteroffre', component: AjouterOffre, name: "AjouterOffre" , beforeEnter: adminGuard},
      { path:'/offer/:id' , component:OfferDetailsAdmin , name:"OfferDetailsAdmin", beforeEnter: adminGuard},
      { path: '/OffersListAdmin', component: OffersListAdmin, name: "OffersListAdmin", beforeEnter: adminGuard},
      {path: '/ListeEnfantActivites/:id',component:ListeEnfantActivites,name:"ListeEnfantActivites", beforeEnter: adminGuard},
      {path: '/sidebar',component:sidebar,name:"sidebar", beforeEnter: adminGuard},
      {path: '/TopOffers',component:TopOffers,name:"TopOffers", beforeEnter: adminGuard},
      {path: '/ActivitylistAdmin',component:ActivitylistAdmin,name:"ActivitylistAdmin", beforeEnter: adminGuard},
      {path: '/Animateur',component:Animateur,name:"Animateur", beforeEnter: adminGuard},
      {path: '/unauthorized', component: UnaUthorized, name: "unauthorized"},


//Animateur
    { path:'/AnimeAddHoraire' , component:AnimeAddHoraire , name:"AnimeAddHoraire" ,  meta: { requiresAuth: true , roles: ['animateur'] }},
    { path:'/AnimeDispHoraire' , component:AnimeDispHoraire , name:"AnimeDispHoraire",  meta: { requiresAuth: true , roles: ['animateur'] }},
    { path:'/AnimeHoraire' , component:AnimeHoraire , name:"AnimeHoraire",  meta: { requiresAuth: true , roles: ['animateur'] }},
    { path:'/AnimeOcuperHoraire' , component:AnimeOcuperHoraire , name:"AnimeOcuperHoraire",  meta: { requiresAuth: true , roles: ['animateur'] }},
      { path:'/AnimateurDashboard' , component:AnimateurDashboard , name:"AnimateurDashboard",  meta: { requiresAuth: true , roles: ['animateur'] }},
  ]
});

export default router;