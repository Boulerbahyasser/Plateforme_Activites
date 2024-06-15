import { createRouter, createWebHistory } from 'vue-router';
import Contact from "@/components/Contact.vue";
import AproposNous from "@/components/AproposNous.vue";
import ConnexionPage from '@/components/ConnexionPage.vue';
import InscriptionPage from "@/components/InscriptionPage.vue";
import PageAccueil from "@/components/PageAccueil.vue";
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
import EditChild from "@/components/EditChild.vue";
import AdminPage from "@/components/ADMIN/AdminPage.vue";
import AjouterEnfant from "@/components/AjouterEnfant.vue";

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
    { path:'/notificationpage' , component:NotificationsPage , name:"notificationpage" },
    { path:'/notificationhistory' , component:NotificationHistory , name:"notificationhistory"},
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
  ]
});


router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('auth_token'); // Récupérer le token JWT stocké
  const role = localStorage.getItem('user_role'); // Récupérer le rôle de l'utilisateur stocké

  // On Vérifie si la route nécessite une authentification
  if (to.matched.some(record => record.meta.requiresAuth)) {

    if (!token) {
      next('/ConnexionPage');
    } else {
      // Vérifiant si l'utilisateur a les permissions nécessaires
      if (to.matched.some(record => record.meta.roles && !record.meta.roles.includes(role))) {
        next('/unauthorized');
      } else {
        next();
      }
    }
  } else {
    next();
  }
});

export default router;