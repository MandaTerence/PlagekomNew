import {createWebHistory, createRouter} from "vue-router";

import CreationEquipe from '../pages/CreationEquipe';

import Home from '../pages/Home';
import About from '../pages/About';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Planning from '../pages/Planning';
import ControleTelephonique from '../pages/ControleTelephonique';


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
        name: 'controleTelephonique',
        path: '/controleTelephonique',
        component: ControleTelephonique
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
