// @ts-ignore
/* eslint-disable */
import {request} from 'umi';
import {GetRequest, PostRequest} from "@/utils/request";

/** 登录接口 POST /api/login */
export const login = (body: API.LoginParams): API.LoginResult => {
  return PostRequest('/api/login', body);
}

/** 获取当前的用户 GET /api/user/currentUser */
export const currentUser = (): API.CurrentUserResult => {
  return GetRequest('/api/user/currentUser');
}

/** 刷新token GET /api/login/refreshToken */
export const refreshToken = async () => {
  const res = await GetRequest('/api/login/refreshToken')
  localStorage.setItem('token', res.data.token)
}

/** 退出登录接口 POST /api/logout */
export const outLogin = () => {
  GetRequest('/api/logout')
}
//======================================================================================================================


/** 此处后端没有提供注释 GET /api/notices */
export async function getNotices(options?: { [key: string]: any }) {
  return request<API.NoticeIconList>('/api/notices', {
    method: 'GET',
    ...(options || {}),
  });
}

/** 获取规则列表 GET /api/rule */
export async function rule(
  params: {
    // query
    /** 当前的页码 */
    current?: number;
    /** 页面的容量 */
    pageSize?: number;
  },
  options?: { [key: string]: any },
) {
  return request<API.RuleList>('/api/rule', {
    method: 'GET',
    params: {
      ...params,
    },
    ...(options || {}),
  });
}

/** 新建规则 PUT /api/rule */
export async function updateRule(options?: { [key: string]: any }) {
  return request<API.RuleListItem>('/api/rule', {
    method: 'PUT',
    ...(options || {}),
  });
}

/** 新建规则 POST /api/rule */
export async function addRule(options?: { [key: string]: any }) {
  return request<API.RuleListItem>('/api/rule', {
    method: 'POST',
    ...(options || {}),
  });
}

/** 删除规则 DELETE /api/rule */
export async function removeRule(options?: { [key: string]: any }) {
  return request<Record<string, any>>('/api/rule', {
    method: 'DELETE',
    ...(options || {}),
  });
}
