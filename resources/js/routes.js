
import Listings from './components/Listings.vue'
import Home from './components/Home.vue'
const routes = [
    {
        path: '/', component: Home
    },
    {
        path: '/listings', component: Listings
    },
]
export default routes