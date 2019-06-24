// System Tests
testResponseTime = function (response) {
    // Check if response time is less than 2 seconds
    pm.test("testResponseTime: Response time is less than 2s", function () {
        pm.expect(response.responseTime).to.be.below(2000);
    });
}
testCorrect = function (response) {
    // Check if error is false
    pm.test("testCorrect: Error is false", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(false);
    });
}
testError = function (response) {
    // Check if error is true
    pm.test("testError: Error is true", function () {
        var jsonData = response.json();
        pm.expect(jsonData.error).to.eql(true);
    });
}
testStatus = function (response, status) {
    // Assert some status code
    pm.test("testStatus: Status code is " + status, function () {
        response.to.have.status(status);
    });
}
testStatus200 = function (response) {
    // Check if status code is 200 OK
    testStatus(response, 200);
}
testStatus401 = function (response) {
    // Check if status code is 401 Unauthorized
    testStatus(response, 401);
}
testStatus422 = function (response) {
    // Check if status code is 422 Unprocesable
    testStatus(response, 422);
}