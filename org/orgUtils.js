export async function loadOrgData(orgId, {
  nameElementId,
  taglineElementId,
  logoElementId
}) {
  try {
    const response = await fetch(`get_org_by_id.php?id=${orgId}`);
    const data = await response.json();

    if (nameElementId) {
      document.getElementById(nameElementId).textContent = data.org_name;
    }

    if (taglineElementId) {
      const ann = document.getElementById(taglineElementId);
      if (ann) ann.textContent = data.tagline || "No tagline available.";
    }

    if (logoElementId) {
      const logo = document.getElementById(logoElementId);
      logo.src = `get_org_image.php?id=${orgId}`;
      logo.alt = `${data.org_name} Logo`;
    }

  } catch (error) {
    console.error('Failed to load organization data:', error);
  }
}
