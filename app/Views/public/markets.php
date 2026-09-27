<div class="container py-5">
    <div class="mb-4"><span class="eyebrow">Pickup network</span>
        <h1 class="fw-bold">Markets</h1>
        <p class="text-secondary">Explore active markets and the farmers operating in each location.</p>
    </div>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="row g-4"><?php foreach ($markets as $m): ?><div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold"><?= e($m['name']) ?></h5><span class="badge text-bg-success p-2">Active</span>
                                </div>
                                <p class="text-secondary small mt-2 mb-3"><?= e($m['address']) ?></p>
                                <div class="d-flex justify-content-between"><span class="small text-secondary">Farmers</span><strong><?= (int)$m['farmer_count'] ?></strong></div>
                            </div>
                        </div>
                    </div><?php endforeach; ?></div>
        </div>
        <div class="col-lg-5">
             <div class="map-wrapper">
                        <div id="marketMap" class="map-large">

                        </div>
        </div>
    </div>
</div>
</div>
<script>
    window.marketLinkLandingMarkets = <?= json_encode($markets, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.ml-landing .reveal').forEach(function(el) {
            el.classList.add('active');
        });
        var mapEl = document.getElementById('marketMap');
        if (!mapEl || typeof L === 'undefined') return;
        var markets = window.marketLinkLandingMarkets || [];
        var map = L.map(mapEl, {
            scrollWheelZoom: false
        }).setView([24.8607, 67.0011], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        markets.forEach(function(m) {
            var lat = parseFloat(m.latitude),
                lng = parseFloat(m.longitude);
            if (Number.isFinite(lat) && Number.isFinite(lng)) {
                L.marker([lat, lng]).addTo(map).bindPopup('<strong>' + escapeHtml(m.name) + '</strong><br><small>' + escapeHtml(m.address || '') + '</small>');
            }
        });

        function escapeHtml(value) {
            return String(value).replace(/[&<>\'"]/g, function(c) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    "'": '&#39;',
                    '"': '&quot;'
                } [c];
            });
        }
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    });
</script>