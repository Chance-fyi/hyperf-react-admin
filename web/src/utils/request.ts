import {history, request} from "umi";
import {refreshToken} from "@/services/ant-design-pro/api";

const req = async (method: string, url: string, data: any): Promise<any> => {
  const res = await request<API.Result>(url, {
    method,
    data,
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + localStorage.getItem('token')
    },
  })

  const {code} = res
  if (code === 100004 && url !== '/api/logout') {
    await refreshToken()
    return await req(method, url, data)
  } else if (code === 100002 || code === 100003 || code === 100005 || code === 100006) {
    history.push('/user/login')
    return
  }

  return res
}

export const GetRequest = (url: string): any => {
  return req('GET', url, null)
}

export const PostRequest = (url: string, data: any): any => {
  return req('POST', url, data)
}
