import {
  createSlice
  //PayloadAction
} from '@reduxjs/toolkit'
import type { RootState } from '../../index'
import { loadLogin, submitLogin } from './accountApi'
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
  reducers: {
    // login: {
    //   reducer(
    //     state,
    //     action: PayloadAction<{ currentPage: number }>
    //   ) {
    //     state.all = action.payload
    //     state.meta = action.meta
    //   },
    //   prepare(payload: Page[], currentPage: number) {
    //     return { payload, meta: { currentPage } }
    //   }
    // }
  },
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
      .addCase(submitLogin.pending, (state) => {
        state.status = 'pending'
      })
      .addCase(submitLogin.fulfilled, (state, action) => {
        state.data = action.payload

        console.log(action.payload)
        state.status = 'success'
      })
      .addCase(submitLogin.rejected, (state, action) => {
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

export { loadLogin, submitLogin }
