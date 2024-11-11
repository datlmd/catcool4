import { configureStore } from '@reduxjs/toolkit'
import { contactSlice } from './modules/contact/contactSlice'
import { aboutSlice } from './modules/about/aboutSlice'
import { loginSlice } from './modules/account/loginSlice'

export const store = configureStore({
  reducer: {
    contact: contactSlice.reducer,
    about: aboutSlice.reducer,
    login: loginSlice.reducer
  }
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>

// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
