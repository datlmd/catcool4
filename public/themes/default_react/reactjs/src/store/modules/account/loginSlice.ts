import {
  createSlice
  //PayloadAction
} from '@reduxjs/toolkit'
import type { RootState } from '../../index'
import { loadLogin } from './accountApi'
import { IPage } from '../../types'

// Define the initial state using that type
const initialState: IPage = {
  data: [],
  status: 'idle',
  error: null
}

export const loginSlice = createSlice({
  name: 'login',
  // `createSlice` will infer the state type from the `initialState` argument
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(loadLogin.pending, (state) => {
        state.status = 'pending'
      })
      .addCase(loadLogin.fulfilled, (state, action) => {
        state.data = action.payload
        state.status = 'success'
      })
      .addCase(loadLogin.rejected, (state, action) => {
        state.status = 'failed'
        state.error = action.error.message ?? 'Unknown Error'
      })
  }
})

export const pageData = (state: RootState) => state.login.data
export const pageStatus = (state: RootState) => state.login.status
export const pageError = (state: RootState) => state.login.error

//export const {} = loginSlice.actions

export default loginSlice.reducer

export { loadLogin }
