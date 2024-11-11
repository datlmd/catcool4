import { API, getRequestToken } from '../../../utils/callApi'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const loadAbout = createAsyncThunk('page/about', async () => {
  try {
    const res = await API.get('frontend/api/about', getRequestToken())
    return res.data
  } catch (error) {
    console.log(error)
  }
})
