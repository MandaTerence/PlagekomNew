import {createWebHistory, createRouter} from "vue-router";

import CreationEquipe from '../pages/CreationEquipe';

import Home from '../pages/Home';
import About from '../pages/About';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Planning from '../pages/Planning';
import ControleTelephonique from '../pages/ControleTelephonique';
import TimeLine from '../pages/TimeLine';
import Classements from '../pages/Classements';
import ClassificationCommerciaux from '../pages/ClassificationCommerciaux';
import Fiche from '../pages/Fiche';
import Salaire from '../pages/Salaire';
import Evaluation from '../pages/Evaluation';

import Books from '../components/Books';
import AddBook from '../components/AddBook';
import EditBook from '../components/EditBook';

export const routes = [
    {
        name: 'creationEquipe',
        path: '/creationEquipe',
        component: CreationEquipe
    },
    {
        name: 'Evaluation',
        path: '/Evaluation',
        component: Evaluation
    },
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'classificationCommerciaux',
        path: '/classificationCommerciaux',
        component: ClassificationCommerciaux
    },
    {
        name: 'Fiche',
        path: '/Fiche',
        component: Fiche
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'books',
        path: '/books',
        component: Books
    },
    {
        name: 'addbook',
        path: '/books/add',
        component: AddBook
    },
    {
        name: 'editbook',
        path: '/books/edit/:idMission',
        component: EditBook
    },
    {
        name: 'planning',
        path: '/planning',
        component: Planning
    },
    {
        name: 'classements',
        path: '/classements',
        component: Classements
    },
    {
        name: 'controleTelephonique',
        path: '/controleTelephonique',
        component: ControleTelephonique
    },
    {
        name: 'TimeLine',
        path: '/TimeLine',
        component: TimeLine
    },
    {
        name: 'Salaire',
        path: '/Salaire',
        component: Salaire
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
