function poll() {
  pollBackend();
  setTimeout(poll, 5000)
}
poll();
