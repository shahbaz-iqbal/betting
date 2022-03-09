// const CategoryList = () => import('./components/category/list.vue' /* webpackChunkName: "resource/js/components/category/list" */)
import Vue from "vue";
import Router from "vue-router";
import CategoryList from "./components/category/list.vue";

Vue.use(Router);
export const routes = [
    {
        name: 'categoryList',
        path: '/categoies',
        component: CategoryList
    }
]