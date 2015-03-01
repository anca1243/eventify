function checkPostcode(postcode) {
  console.log(postcode);
  var regex = '^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]';
  regex += '([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9]';
  regex += '[ABD-HJLNP-UW-Z]{2})$';
  var re = new RegExp(regex);
  var result = re.exec(postcode);
  if (result) {
    return true;
  } else {
    return false;
  }
}

