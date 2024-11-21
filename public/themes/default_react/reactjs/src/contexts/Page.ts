import { createContext } from 'react'
import { IPageContext } from '../store/types'

const initialIPageContext: IPageContext = {
  token: {
    name: null,
    value: null
  },
  customer: null
}

export const PageContext = createContext<IPageContext>(initialIPageContext)
