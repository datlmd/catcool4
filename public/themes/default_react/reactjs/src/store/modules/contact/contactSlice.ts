import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import type { RootState } from '../../index';
import { loadContact } from './contactApi';
import { IPage } from '../../types';

// Define the initial state using that type
const initialState: IPage = {
  data: [],
  status: 'idle',
  error: null
};

export const contactSlice = createSlice({
  name: 'contact',
  // `createSlice` will infer the state type from the `initialState` argument
  initialState,
  reducers: {
    clearSuccessMessage: (state, payload) => {
      // TODO: Update state to clear success message
    }
  },
  extraReducers: (builder) => {
    builder
      .addCase(loadContact.pending, (state, action) => {
        state.status = 'pending'
      })
      .addCase(loadContact.fulfilled, (state, action) => {
        state.data = action.payload;
        state.status = 'success';
      })
      .addCase(loadContact.rejected, (state, action) => {
        state.status = 'failed';
        state.error = action.error.message ?? 'Unknown Error';
      });
  }
});

export const contactData = (state: RootState) => state.contact.data;
export const contactStatus = (state: RootState) => state.contact.status;
export const contactError = (state: RootState) => state.contact.error;

export const { 
  clearSuccessMessage
} = contactSlice.actions;

export default contactSlice.reducer;

export {
  loadContact,
};