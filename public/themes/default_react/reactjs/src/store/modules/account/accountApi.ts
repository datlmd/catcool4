import { API, getRequestToken } from '../../../utils/callApi'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const loadLogin = createAsyncThunk('page/login', async () => {
  try {
    const res = await API.get('account/api/login', getRequestToken())
    return res.data
  } catch (error) {
    console.log(error)
  }
})

export const submitLogin = createAsyncThunk('page/submitLogin', async (params) => {
  try {
    const res = await API.post('account/api/login', params, getRequestToken())
    return res.data
  } catch (error) {
    console.log(error)
  }
})
