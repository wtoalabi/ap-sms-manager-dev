class Errors {
  constructor() {
    this.allErrors = {};
  }

  any() {
    return Object.keys(this.allErrors).length > 0;
  }

  has(field) {
    return this.allErrors.hasOwnProperty(field);
  }

  get(field) {
    if (this.allErrors[field]) {
      return this.allErrors[field][0];
    }
  }

  record(errors) {
    this.allErrors = errors;
  }

  clear(field) {
    if (field) {
      delete this.allErrors[field];
      return;
    }
    this.allErrors = {};
  }

  clearAll() {
    this.allErrors = {};
  }
}

export default Errors;
