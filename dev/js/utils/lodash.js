import has from 'lodash-es/has'
import minBy from 'lodash-es/minBy'
import maxBy from 'lodash-es/maxBy'
import difference from 'lodash-es/difference'
import isEmpty from 'lodash-es/isEmpty'
import truncate from 'lodash-es/truncate'
import chunk from 'lodash-es/chunk'
import map from 'lodash-es/map'
import cloneDeep from 'lodash-es/cloneDeep'
import uniq from 'lodash-es/uniq';
import uniqBy from 'lodash-es/uniqBy';
import isUndefined from 'lodash-es/isUndefined';
import take from 'lodash-es/take';
import last from 'lodash-es/last';
import once from 'lodash-es/once';
import isArray from 'lodash-es/isArray';
import isNull from 'lodash-es/isNull';


let isNotEmpty = (value) => {
  return !isEmpty(value);
};
let debouncedTimer = 0;
let debounce = (func, timeout) => {

  clearTimeout(debouncedTimer);

  debouncedTimer = setTimeout(() => {
    func();
  }, timeout)

};

let isEmail = (email) => {
  let regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(String(email).toLowerCase());
};

function isRandomText(length = 20) {
  let result = '';
  let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  let charactersLength = characters.length;
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

function isPhoneNumber(phone) {
  if (!phone.startsWith("+")) {
    return false;
  }
  if (phone.length <= 5) {
    return false;
  }
  let split = phone.split("+");
  return isNumber(split[1])
}

function isNumber(val) {
  return /^\d+$/.test(val);
}

function isNotFilled(value) {
  if(isNumber(value)) return false;
  return isEmpty(value);
}

export default {
  has,
  isEmpty,
  debounce,
  isEmail,
  truncate,
  chunk,
  map,
  cloneDeep,
  uniq,
  minBy,
  maxBy,
  isNotEmpty,
  take,
  last,
  difference,
  uniqBy,
  isUndefined,
  once,
  isArray,
  isRandomText,
  isPhoneNumber,
  isNumber,
  isNull,
  isNotFilled
}
