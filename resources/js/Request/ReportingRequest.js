import ReportingHttp from '../Http/ReportingHttp'
import Alert from '../services/Alert'

export default {
  async create (data) {
    const response = await ReportingHttp.create(data)
    if (!response.isCreated) return
    Alert.success(`Successfully reported the ${data.type}`)
    return response
  }
}
