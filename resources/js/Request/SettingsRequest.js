import { isEmpty } from 'lodash'
import SettingsHttp from '../Http/SettingsHttp'
import SettingsState from '../State/SettingsState'

export default {
  async update () {
    const data = SettingsState.collectSettings()
    const settings = await SettingsHttp.update(data)
    if (isEmpty(settings)) return
    SettingsState.replaceSettings(settings)
  }
}
