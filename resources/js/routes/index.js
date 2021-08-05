import authMiddleware from '../middleware/authMiddleware'

import Landing from '../views/Landing'
import SignUp from '../views/SignUp'
import SentActivation from '../views/SentActivation'
import SignIn from '../views/SignIn'
import ResendActivation from '../views/ResendActivation'
import Verify from '../views/Verify'
import ResetPassword from '../views/ResetPassword'
import SentPasswordReset from '../views/SentPasswordReset'
import UpdatePassword from '../views/UpdatePassword'
import Home from '../views/Home'
import People from '../views/People'
import Notifications from '../views/Notifications'
import Messages from '../views/Messages'
import Favourites from '../views/Favourites'
import TopPosts from '../views/TopPosts'
import Settings from '../views/Settings'
import Team from '../views/Team'
import Profile from '../views/Profile'
import HashtagResult from '../views/HashtagResult'
import Search from '../views/Search'
import Post from '../views/Post'
import AccountDelete from '../views/AccountDelete'
import AboutUs from '../views/AboutUs'
import PrivacyPolicy from '../views/PrivacyPolicy'
import TermsOfUse from '../views/TermsOfUse'
import Help from '../views/Help'
import NotFound from '../views/NotFound'

export default [
  { path: '/', name: 'Landing', component: Landing },
  { path: '/sign-up', name: 'SignUp', component: SignUp },
  { path: '/sent-activation', name: 'SentActivation', component: SentActivation },
  { path: '/sign-in', name: 'SignIn', component: SignIn },
  { path: '/resend-activation', name: 'ResendActivation', component: ResendActivation, props: route => ({ email: route.query.email }) },
  { path: '/verify/:token', name: 'Verify', component: Verify },
  { path: '/reset-password', name: 'ResetPassword', component: ResetPassword },
  { path: '/sent-password-reset', name: 'SentPasswordReset', component: SentPasswordReset },
  { path: '/password/update/:token', name: 'UpdatePassword', component: UpdatePassword },

  { path: '/home', name: 'Home', component: Home, beforeEnter: authMiddleware, meta: { auth: true, darkMode: true, col: 2, fullWidth: true } },
  { path: '/notifications', name: 'Notifications', component: Notifications, beforeEnter: authMiddleware, meta: { auth: true, darkMode: true, col: 2 } },
  { path: '/people', name: 'People', component: People, beforeEnter: authMiddleware, meta: { auth: true, darkMode: true, col: 1 } },
  { path: '/favorites', name: 'Favourites', component: Favourites, beforeEnter: authMiddleware, meta: { auth: true, darkMode: true, col: 2 } },
  { path: '/messages', name: 'Messages', component: Messages, beforeEnter: authMiddleware, meta: { auth: true, darkMode: true, col: 1 } },
  { path: '/settings', name: 'Settings', component: Settings, beforeEnter: authMiddleware, meta: { auth: true, darkMode: true, col: 1 } },

  { path: '/top-posts', name: 'TopPosts', component: TopPosts, meta: { auth: true, darkMode: true, col: 2 } },
  { path: '/team/:slug', name: 'Team', component: Team, meta: { auth: true, darkMode: true, col: 2 } },
  { path: '/user/:username', name: 'Profile', component: Profile, meta: { auth: true, darkMode: true, col: 2 } },
  { path: '/hashtags/:hashtag', name: 'HashtagResult', component: HashtagResult, meta: { auth: true, darkMode: true, col: 2 } },
  { path: '/search', name: 'Search', component: Search, meta: { auth: true, darkMode: true, col: 2 } },
  { path: '/post/:id', name: 'Post', component: Post, meta: { auth: true, darkMode: true, col: 2 } },

  { path: '/account-delete', name: 'AccountDelete', component: AccountDelete },
  { path: '/about-us', name: 'AboutUs', component: AboutUs },
  { path: '/privacy-policy', name: 'PrivacyPolicy', component: PrivacyPolicy },
  { path: '/terms-of-use', name: 'TermsOfUse', component: TermsOfUse },
  { path: '/help', name: 'Help', component: Help },
  { path: '/*', name: 'NotFound', component: NotFound }
]
