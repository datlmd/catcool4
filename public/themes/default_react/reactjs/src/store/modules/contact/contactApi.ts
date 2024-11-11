import { API, getRequestToken } from "../../../utils/callApi";
import { createAsyncThunk } from "@reduxjs/toolkit";

export const loadContact = createAsyncThunk("page/contact", async () => {
  try {
    const res = await API.get(
      "frontend/api/contact",
      getRequestToken()
    );
    return res.data;
  } catch (error) {
    console.log(error);
  }
});