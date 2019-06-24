// System Tests
systemResponseTime = function (response) {
    // Check if response time is less than 2 seconds
    pm.test("systemResponseTime: Response time is less than 2s", function () {
        pm.expect(response.responseTime).to.be.below(2000);
    });
}
systemCorrect = function (response) {
    // Check if error is false
    pm.test("systemCorrect: Error is false", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(false);
    });
}
systemError = function (response) {
    // Check if error is true
    pm.test("systemError: Error is true", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(true);
    });
}
systemStatus = function (response, status) {
    // Assert some status code
    pm.test("systemStatus: Status code is " + status, function () {
        response.to.have.status(status);
    });
}
systemStatus200 = function (response) {
    // Check if status code is 200 OK
    systemStatus(response, 200);
}
systemStatus401 = function (response) {
    // Check if status code is 401 Unauthorized
    systemStatus(response, 401);
}
systemStatus422 = function (response) {
    // Check if status code is 422 Unprocesable
    systemStatus(response, 422);
}
// Aceptance
aceptanceR1  = function (response) {
    // System Tests
    // systemCorrect(response);
    // systemStatus200(response);
}
aceptanceR2  = function (response) {
    // System Tests
    // systemCorrect(response);
    // systemStatus200(response);
}
aceptanceR3  = function (response) {
    // System Tests
    // systemCorrect(response);
    // systemStatus200(response);
}
aceptanceR4  = function (response) {
    // System Tests
    // systemCorrect(response);
    // systemStatus200(response);
}
// Integration
integrationOK = function (response) {
    // System Tests
    systemCorrect(response);
    systemStatus200(response);
    // Check if error is false
    pm.test("unitLB: Is correct", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(false);
    });
}
// Unit Tests
unitBLB = function (response) {
    // System Tests
    systemError(response);
    systemStatus422(response);
    // Check if error is true
    pm.test("unitBLB: Throws error", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(true);
    });
}
unitLB = function (response) {
    // System Tests
    systemCorrect(response);
    systemStatus200(response);
    // Check if error is true
    pm.test("unitLB: Is correct", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(false);
    });
}
unitALB = function (response) {
    // System Tests
    systemCorrect(response);
    systemStatus200(response);
    // Check if error is true
    pm.test("unitALB: Is correct", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(false);
    });
}
