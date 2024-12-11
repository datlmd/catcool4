import {
  createSlice,
  createAsyncThunk
} from '@reduxjs/toolkit'
import type { RootState } from '../../index'
import { callUrl } from './accountApi'
import { IPage } from '../../types'

// Define the initial state using that type
const initialState: IPage = {
  data: [],
  status: 'idle',
  error: null
}

export const loadProfile = createAsyncThunk('page/profile', async () => {
  return await callUrl('account/api/profile')
})

export const profileSlice = createSlice({
  name: 'profile',
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
      .addCase(loadProfile.pending, (state) => {
        state.status = 'pending'
      })
      .addCase(loadProfile.fulfilled, (state, action) => {
        state.data = action.payload
        state.status = 'success'
      })
      .addCase(loadProfile.rejected, (state, action) => {
        state.status = 'failed'
        state.error = action.error.message ?? 'Unknown Error'
      })
  }
})

export const pageData = (state: RootState) => state.profile.data
export const pageStatus = (state: RootState) => state.profile.status
export const pageError = (state: RootState) => state.profile.error

//export const {} = loginSlice.actions

export default profileSlice.reducer
