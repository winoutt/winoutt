<template lang="pug">
  .settings-profile
    .row.avatar
      .col
        InputImage.profile-avatar.mt-3.mx-auto(
          :default="avatar"
          @change="updateAvatar"
          circle="true",
          type="fixed",
          :size="3"
        )
    .row
      .col-md
        .form-group
          label.font-weight-bold First name
          InputSmall(
            placeholder="John"
            v-model="firstName"
            :data-value="firstName"
            v-max-character="20"
            required-field="true"
          )
      .col-md
        .form-group
          label.font-weight-bold Last name
          InputSmall(
            placeholder="Smith"
            v-model="lastName"
            :data-value="lastName"
            v-max-character="20"
            required-field="true"
          )
    .row
      .col-md
        .form-group
          label.font-weight-bold Username
          InputSmall(
            placeholder="johnsmith"
            v-model="username"
            :data-value="username"
            v-max-character="20"
            required-field="true"
          )
      .col-md
        .form-group
          label.font-weight-bold Email
          InputSmall(
            type="email"
            placeholder="johnsmith@gmail.com"
            v-model="email"
            :data-value="email"
            v-max-character="30"
            required-field="true"
          )
    .row
      .col
        .form-group
          label.font-weight-bold Bio
          Textarea(
            placeholder="e.g., Independent software developer focused on clean and elegant web designs. Avid reader. Active writer. Enthusiastic traveler."
            rows="3"
            v-model="bio"
            :autosize="true"
            :data-value="bio"
            v-max-character="2500"
            required-field="true"
          )
    .row
      .col-md
        .form-group
          label.font-weight-bold Websites
          InputSmall(
            placeholder="Company website"
            v-model="companyWebsite"
            :data-value="companyWebsite"
            v-max-character="120"
          )
      .col-md
        .form-group
          label.font-weight-bold.d-none.d-md-block &nbsp;
          InputSmall(
            placeholder="Personal website"
            v-model="personalWebsite"
            :data-value="personalWebsite"
            v-max-character="120"
          )
    .row
      .col-md
        .form-group
          label.font-weight-bold Date of birth
          Datepicker(
            placeholder="02/18/1990"
            v-model="dateOfBirth"
            :disabled-dates="{ from: new Date() }"
            format="MM/dd/yyyy"
            :bootstrap-styling="true"
            :typeable="true"
            :data-value="dateOfBirth"
            required-field="true"
          )
      .col-md
        .form-group
          label.font-weight-bold Gender
          SelectSmall(
            v-model="gender"
            :data-value="gender"
            required-field="true"
          )
            option(value="" selected disabled) Please select
            option(value="male") Male
            option(value="female") Female
            option(value="unspecified") Unspecified
    .row
      .col-md
        .form-group
          label.font-weight-bold City
          InputSmall(
            placeholder="San Antonio"
            v-model="city"
            :data-value="city"
            v-max-character="20"
            required-field="true"
          )
      .col-md
        .form-group
          label.font-weight-bold Country
          SelectCountries(
            v-model="country"
            :data-value="country"
            required-field="true"
          )
    .row
      .col-md
        .form-group
          label.font-weight-bold Define yourself
          SelectSmall(
            v-model="title"
            :data-value="title"
            required-field="true"
          )
            option(value="" selected disabled) Please select
            option(v-for="title in titles" :value="title") {{ title }}
      .col-md
        .form-group(v-if="title === 'Custom'")
          label.font-weight-bold.d-none.d-md-block &nbsp;
          InputSmall(
            placeholder="e.g. College Student"
            v-model="customTitle"
            :data-value="customTitle"
            v-max-character="97"
            required-field="true"
          )
    .row
      .col-md
        SettingsButton(text="Save" @click.native="updateUser()")
    SettingsCropAvatarModal(:avatar="avatarTemp" @change="updateCroppedAvatar")
</template>

<script lang="ts">
import Vue from 'vue'
import moment from 'moment'
import { clone, includes, isEmpty } from 'lodash'
import SettingsModalService from '../../../services/ModalServices/SettingsModalService'
import UserRequest from '../../../Request/UserRequest'
import Url from '../../../services/Url'
import Alert from '../../../services/Alert'
import Validate from '../../../services/Validate'

import Datepicker from 'vuejs-datepicker'
import InputImage from '../../input/InputImage.vue'
import InputSmall from '../../input/InputSmall.vue'
import Textarea from '../../Textarea.vue'
import SelectSmall from '../../select/SelectSmall.vue'
import SelectCountries from '../../select/SelectCountries.vue'
import SettingsButton from '../settings/SettingsButton.vue'
import SettingsCropAvatarModal from './SettingsCropAvatarModal.vue'
import maxCharacter from '../../../directives/maxCharacter'
import SettingsState from '../../../State/SettingsState'

export default Vue.extend({
  components: {
    Datepicker,
    InputImage,
    InputSmall,
    Textarea,
    SelectSmall,
    SelectCountries,
    SettingsButton,
    SettingsCropAvatarModal
  },

  directives: {
    maxCharacter
  },

  computed: {
    user () {
      return SettingsState.collectUser()
    },
    avatar: {
      get: () => SettingsState.collectAvatar(),
      set: avatar => SettingsState.replaceAvatar(avatar)
    },
    firstName: {
      get: () => SettingsState.collectFirstName(),
      set: firstName => SettingsState.replaceFirstName(firstName)
    },
    lastName: {
      get: () => SettingsState.collectLastName(),
      set: lastName => SettingsState.replaceLastName(lastName)
    },
    username: {
      get: () => SettingsState.collectUsername(),
      set: username => SettingsState.replaceUsername(username)
    },
    email: {
      get: () => SettingsState.collectEmail(),
      set: email => SettingsState.replaceEmail(email)
    },
    bio: {
      get: () => SettingsState.collectBio(),
      set: bio => SettingsState.replaceBio(bio)
    },
    companyWebsite: {
      get: () => SettingsState.collectCompanyWebsite(),
      set: companyWebsite => SettingsState.replaceCompanyWebsite(companyWebsite)
    },
    personalWebsite: {
      get: () => SettingsState.collectPersonalWebsite(),
      set: personalWebsite => SettingsState.replacePersonalWebsite(personalWebsite)
    },
    dateOfBirth: {
      get: () => SettingsState.collectDateOfBirth(),
      set: dateOfBirth => SettingsState.replaceDateOfBirth(dateOfBirth)
    },
    gender: {
      get: () => SettingsState.collectGender(),
      set: gender => SettingsState.replaceGender(gender)
    },
    city: {
      get: () => SettingsState.collectCity(),
      set: city => SettingsState.replaceCity(city)
    },
    country: {
      get: () => SettingsState.collectCountry(),
      set: country => SettingsState.replaceCountry(country)
    },
    title: {
      get () {
        const title = SettingsState.collectTitle()
        if (!title) return '' // For placeholder
        const isCustomTitle = !includes(this.titles, title)
        if (isCustomTitle) SettingsState.replaceCustomTitle(title)
        return isCustomTitle ? 'Custom' : title
      },
      set: title => SettingsState.replaceTitle(title)
    },
    customTitle: {
      get () {
        return SettingsState.collectCustomTitle()
      },
      set: customTitle => SettingsState.replaceCustomTitle(customTitle)
    },
    today () {
      return moment().format('YYYY-MM-DD')
    }
  },

  data () {
    return {
      titles: [
        'Entrepreneur',
        'Intrapreneur',
        'Investor',
        'Entrepreneur & Investor',
        'Custom'
      ],
      avatarTemp: ''
    }
  },

  methods: {
    updateAvatar (file) {
      this.avatarTemp = file
      this.openAvatarCropModal()
    },
    updateCroppedAvatar (uri) {
      this.avatar = uri
    },
    updateUser () {
      if (!Validate.isFilledRequiredFields()) {
        return Alert.error(Validate.message.completeRequiredFields)
      }
      const payload = clone(this.user)
      if (!isEmpty(this.avatarTemp)) {
        this.avatarTemp = ''
        payload.avatar = {
          uri: payload.avatar,
          extension: 'png'
        }
      }
      if (payload.date_of_birth) {
        const { date_of_birth: dateOfBirth } = payload
        payload.date_of_birth = moment(dateOfBirth).format('YYYY-MM-DD')
      }
      payload.website.company = this.Util.sanitizeUrl(payload.website.company)
      payload.website.personal = this.Util.sanitizeUrl(payload.website.personal)
      if (payload.website.company && !Url.isValid(payload.website.company)) {
        return Alert.error('Please add a valid company website.')
      }
      if (payload.website.personal && !Url.isValid(payload.website.personal)) {
        return Alert.error('Please add a valid personal website.')
      }
      payload.define_yourself = (this.title === 'Custom')
        ? this.customTitle
        : this.title
      UserRequest.edit(payload)
    },
    openAvatarCropModal () {
      SettingsModalService.cropAvatar().open()
    }
  }
})
</script>

<style lang="sass" scoped>
.settings-profile
  .avatar
    margin-bottom: 38px
    .profile-avatar
      width: 92px
      height: 92px
</style>
