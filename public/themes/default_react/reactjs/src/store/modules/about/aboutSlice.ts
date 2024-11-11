import { createSlice } from '@reduxjs/toolkit'
import type { RootState } from '../../index'
import { loadAbout } from './aboutApi'
import { IPage } from '../../types'

// Define the initial state using that type
const initialState: IPage = {
  data: [],
  status: 'idle',
  error: null
}

export const aboutSlice = createSlice({
  name: 'about',
  // `createSlice` will infer the state type from the `initialState` argument
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(loadAbout.pending, (state) => {
        state.status = 'pending'
      })
      .addCase(loadAbout.fulfilled, (state, action) => {
        state.data = action.payload
        state.status = 'success'
      })
      .addCase(loadAbout.rejected, (state, action) => {
        state.status = 'failed'
        state.error = action.error.message ?? 'Unknown Error'
      })
  }
})

export const aboutData = (state: RootState) => state.about.data
export const aboutStatus = (state: RootState) => state.about.status
export const aboutError = (state: RootState) => state.about.error

// export const {

// } = aboutSlice.actions

export default aboutSlice.reducer

export { loadAbout }
