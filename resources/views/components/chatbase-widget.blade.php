@if(config('services.chatbase.enabled') && config('services.chatbase.bot_id'))
<!-- Chatbase Widget EcoEvents -->
<script>
window.embeddedChatbotConfig = {
chatbotId: "{{ config('services.chatbase.bot_id') }}",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="{{ config('services.chatbase.bot_id') }}"
domain="www.chatbase.co"
defer>
</script>
@endif